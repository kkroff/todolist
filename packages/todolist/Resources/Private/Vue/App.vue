<template>
  <div>
    <button class="menu-toggle" @click="isMenuOpen = !isMenuOpen"></button>

    <div v-if="isMenuOpen" class="floating-menu">
      <h3>{{ formatToLocaleDate(currentDateFormatted) }}</h3>
      <button @click="decreaseDateBy1Day">- 1 Tag</button>
      <button @click="increaseDateBy1Day">+ 1 Tag</button>
    </div>
  </div>

  <div class="container text-center">
    <div class="row justify-content-center">
      <div class="col-sm-10 task-form-box">
        <div class="row g-2">
          <div class="col-sm-10 d-flex flex-column gap-2">
            <input type="text" class="form-control" placeholder="Titel der Aufgabe" v-model="newTaskTitle" maxlength="255"/>
            <input type="text" class="form-control" placeholder="Beschreibung hinzufügen" v-model="newTaskDescription" maxlength="255"/>
            <input type="date" class="form-control" v-model="newTaskDueDate" />
          </div>
          <div class="col-sm-2 d-flex align-items-stretch">
            <button type="button" class="btn btn-primary w-100 fw-bold fs-3" @click="addTask">+</button>
          </div>
        </div>
      </div>

      <div class="col-sm-10 task-list-box">
        <h4>{{ pendingTasks }} offene ToDos</h4>

        <div class="card item-card mt-3"
             v-for="(task, index) in sortedTasks"
             :key="index"
             :class="getTaskCssClass(task)">
          <div class="card-body">
            <div class="d-flex align-items-start gap-3 flex-wrap flex-md-nowrap" v-if="!task.isEditing">
              <div class="pt-2">
                <button class="done-button" :class="{ done: task.isDone }" @click="toggleDoneAndSave(task)">
                  {{ task.isDone ? '✓' : '' }}
                </button>
              </div>

              <div class="flex-grow-1">
                <p class="fw-semibold mb-1">{{ task.title }}</p>
                <p v-if="task.description" class="mb-1">{{ task.description }}</p>
                <p v-if="task.dueDate">{{ formatToLocaleDate(task.dueDate) }}</p>
              </div>

              <div class="d-flex flex-column gap-2">
                <button class="btn btn-sm btn-outline-dark" @click="startEditing(task)">Bearbeiten</button>
                <button class="btn btn-sm btn-outline-dark" @click="deleteTask(index)">Löschen</button>
              </div>
            </div>

            <div v-else>
              <input v-model="task.editingValues.title" class="form-control mb-2" placeholder="Titel" maxlength="255" />
              <input v-model="task.editingValues.description" class="form-control mb-2" placeholder="Beschreibung" maxlength="255"/>
              <input v-model="task.editingValues.dueDate" type="date" class="form-control mb-3" />
              <button class="btn btn-sm btn-outline-dark me-2" @click="saveTask(task)">Speichern</button>
              <button class="btn btn-sm btn-outline-dark" @click="cancelEditing(task)">Abbrechen</button>
            </div>
          </div>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-end mt-3">
          <button type="button" class="btn btn-primary me-2" @click="deleteCompletedTasks" v-show="tasks.length > 0">Alle Erledigten löschen</button>
          <button type="button" class="btn btn-primary" @click="deleteAllTasks" v-show="tasks.length > 0">Alle löschen</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import axios from 'axios'

export default {
  setup() {
    const PID = 7; //TYPO3 PID

    const api = axios.create({
      baseURL: '/_api',
      headers: {
        'Content-Type': 'application/json'
      }
    })

    // -- UI Control --
    const isMenuOpen = ref(false);
    const currentDate = ref(new Date());

    // -- Form binding --
    const newTaskTitle = ref("");
    const newTaskDescription = ref("");
    const newTaskDueDate = ref("");

    const tasks = ref([]);


    // -- computed --
    const sortedTasks = computed(() => {
      return tasks.value.slice().sort((a, b) => {

        if (!a.dueDate && !b.dueDate) return 0;

        if (!a.dueDate) return 1;

        if (!b.dueDate) return -1;

        return new Date(a.dueDate) - new Date(b.dueDate);
      });
    });

    const pendingTasks = computed(() => {
      return tasks.value.filter((x) => x.isDone === false).length;
    });

    const currentDateFormatted = computed(() => currentDate.value);

    // -- API Task Actions --
    onMounted(() => {
      loadTasksFromApi();
    });

    async function loadTasksFromApi() {
      try {
        const response = await api.get('/task')
        //console.log('response.data:', response.data)

        tasks.value = response.data['hydra:member'] || response.data
      } catch (error) {
        console.error('loadTasksFromApi error:', error)
      }
    }


    const addTask = async () => {
      if (!newTaskTitle.value) return;

      const payload = {
        title: newTaskTitle.value,
        description: newTaskDescription.value,
        dueDate: newTaskDueDate.value
            ? formatDateForApi(newTaskDueDate.value)
            : null,
        isDone: false,
        pid: PID
      }


      try {
        const response = await api.post('/task', payload)
        //console.log('response.data:', response.data)

        //import!! here we get uid of typo3 task object
        const newTask = {
          ...response.data,
          isEditing: false
        }

        tasks.value.unshift(newTask)

        newTaskTitle.value = ""
        newTaskDescription.value = ""
        newTaskDueDate.value = ""
      } catch (error) {
        console.error('addTask error:', error)
      }
    };

    const deleteTask = async (index) => {
      const task = tasks.value[index]

      if (!task.uid) {
        console.warn('Task has no UID/ID - cannot be deleted ')
        return
      }

      try {
        await api.delete(`/task/${task.uid}`)
        tasks.value.splice(index, 1)
      } catch (err) {
        console.error('deleteTask error:', err)
      }
    }

    const deleteAllTasks = async () => {
      try {
        const deletions = tasks.value.map(task =>
            api.delete(`/task/${task.uid}`)
        )

        await Promise.all(deletions)
        tasks.value = []
      } catch (err) {
        console.error('deleteAllTasks error:', err)
      }
    }

    const deleteCompletedTasks = async () => {
      const completed = tasks.value.filter(task => task.isDone && task.uid)

      try {
        const deletions = completed.map(task =>
            api.delete(`/task/${task.uid}`)
        )

        await Promise.all(deletions)
        tasks.value = tasks.value.filter(task => !task.isDone)
      } catch (err) {
        console.error('deleteCompletedTasks error:', err)
      }
    }

    const saveTask = async (task) => {
      const updatedFields = {
        title: task.editingValues.title,
        description: task.editingValues.description,
        dueDate: task.editingValues.dueDate
            ? formatDateForApi(task.editingValues.dueDate)
            : null,
        pid: PID
      }

      try {
        await api.patch(`/task/${task.uid}`, updatedFields)

        task.title = updatedFields.title
        task.description = updatedFields.description
        task.dueDate = updatedFields.dueDate
        task.isEditing = false
        delete task.editingValues
      } catch (err) {
        console.error('saveTask error:', err)
      }
    }

    const toggleDoneAndSave = async (task) => {
      task.isDone = !task.isDone

      const payload = {
        title: task.title,
        description: task.description,
        dueDate: task.dueDate ? formatDateForApi(task.dueDate) : null,
        isDone: task.isDone,
        pid: PID
      }

      try {
        await api.patch(`/task/${task.uid}`, payload)
      } catch (err) {
        console.error('toggleDone error:', err)
        task.isDone = !task.isDone
      }
    }

    const startEditing = (task) => {
      task.editingValues = {
        title: task.title,
        description: task.description,
        dueDate: task.dueDate
      };
      task.isEditing = true;
    };

    const cancelEditing = (task) => {
      task.isEditing = false;
      delete task.editingValues;
    };

    // -- Date Control --
    const increaseDateBy1Day = () => {
      const newDate = new Date(currentDate.value);
      newDate.setDate(newDate.getDate() + 1);
      currentDate.value = newDate;
    };

    const decreaseDateBy1Day = () => {
      const newDate = new Date(currentDate.value);
      newDate.setDate(newDate.getDate() - 1);
      currentDate.value = newDate;
    };

    // -- Helper --
    function getTaskCssClass(task) {
      if (task.isDone) return 'done';
      if (isToday(task.dueDate)) return 'dueToday';
      if (isBeforeToday(task.dueDate)) return 'overdue';
      return '';
    }
    
    function formatToLocaleDate(date) {
      if (!date) return '';
      return new Date(date).toLocaleDateString('de-DE');
    }

    function formatDateForApi(dateString) {
      const date = new Date(dateString)
      return date.toISOString()
    }

    function isBeforeToday(date) {
      if (!date) return false;
      return new Date(date) < new Date(currentDate.value);
    }

    function isToday(date) {
      if (!date) return false;
      const today = new Date(currentDate.value);
      const inputDate = new Date(date);
      return (
          inputDate.getFullYear() === today.getFullYear() &&
          inputDate.getMonth() === today.getMonth() &&
          inputDate.getDate() === today.getDate()
      );
    }

    return {
      isMenuOpen,
      currentDateFormatted,

      newTaskTitle,
      newTaskDescription,
      newTaskDueDate,

      tasks,
      sortedTasks,
      pendingTasks,

      formatToLocaleDate,
      getTaskCssClass,
      addTask,
      deleteTask,
      deleteAllTasks,
      deleteCompletedTasks,
      saveTask,
      toggleDoneAndSave,
      startEditing,
      cancelEditing,
      increaseDateBy1Day,
      decreaseDateBy1Day,
    };
  },
};
</script>
