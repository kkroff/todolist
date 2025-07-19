<template>
  <div>
    <button class="menu-toggle" @click="isMenuOpen = !isMenuOpen"></button>

    <div v-if="isMenuOpen" class="floating-menu">
      <h3>{{ formatDate(formattedDate) }}</h3>
      <button @click="decreaseDateBy1Day">- 1 Tag</button>
      <button @click="increaseDateBy1Day">+ 1 Tag</button>
    </div>
  </div>

  <div class="container text-center">
    <div class="row justify-content-center">
      <div class="col-sm-10 task-form-box">
        <div class="row g-2">
          <div class="col-sm-10 d-flex flex-column gap-2">
            <input type="text" class="form-control" placeholder="Titel der Aufgabe" v-model="newTaskTitle" />
            <input type="text" class="form-control" placeholder="Beschreibung hinzufügen" v-model="newTaskDescription" @keyup.enter="addTask" />
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
             :class="getTaskClass(task)">
          <div class="card-body">
            <div class="d-flex align-items-start gap-3 flex-wrap flex-md-nowrap" v-if="!task.isEditing">
              <div class="pt-2">
                <button class="done-button" :class="{ done: task.isDone }" @click="task.isDone = !task.isDone">
                  {{ task.isDone ? '✓' : '' }}
                </button>
              </div>

              <div class="flex-grow-1">
                <p class="fw-semibold mb-1">{{ task.title }}</p>
                <p v-if="task.description" class="mb-1">{{ task.description }}</p>
                <p v-if="task.dueDate">{{ formatDate(task.dueDate) }}</p>
              </div>

              <div class="d-flex flex-column gap-2">
                <button class="btn btn-sm btn-outline-dark" @click="startEditing(task)">Bearbeiten</button>
                <button class="btn btn-sm btn-outline-dark" @click="deleteTask(index)">Löschen</button>
              </div>
            </div>

            <div v-else>
              <input v-model="task.editingValues.title" class="form-control mb-2" placeholder="Titel" />
              <input v-model="task.editingValues.description" class="form-control mb-2" placeholder="Beschreibung" />
              <input v-model="task.editingValues.dueDate" type="date" class="form-control mb-3" />
              <button class="btn btn-sm btn-outline-dark me-2" @click="saveTask(task, index)">Speichern</button>
              <button class="btn btn-sm btn-outline-dark" @click="cancelEditing(task)">Abbrechen</button>
            </div>
          </div>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-end mt-3">
          <button type="button" class="btn btn-primary" @click="deleteAllTasks" v-show="tasks.length > 0">Alle löschen</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, computed, watch } from "vue";

export default {
  name: "HomePage",
  setup() {
    //UI Control
    const isMenuOpen = ref(false);
    const currentDate = ref(new Date());

    //Form binding
    const newTaskTitle = ref("");
    const newTaskDescription = ref("");
    const newTaskDueDate = ref("");

    const formattedDate = computed(() => currentDate.value);


    const tasks = ref([]);

    const sortedTasks = computed(() => {
      return tasks.value.slice().sort((a, b) => {

        if (!a.dueDate && !b.dueDate) return 0;

        if (!a.dueDate) return 1;

        if (!b.dueDate) return -1;

        return new Date(a.dueDate) - new Date(b.dueDate);
      });
    });


    function getTaskClass(task) {
      if (task.isDone) return 'done';
      if (isToday(task.dueDate)) return 'dueToday';
      if (isBeforeToday(task.dueDate)) return 'overdue';
      return '';
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

    const addTask = () => {
      if (!newTaskTitle.value) return;

      const dueDate = newTaskDueDate.value
          ? newTaskDueDate.value
          : null;

      tasks.value.unshift({
        title: newTaskTitle.value,
        description: newTaskDescription.value,
        dueDate: dueDate,
        isEditing: false,
        isDone: false,
      });
      localStorage.setItem("tasks", JSON.stringify(tasks.value));
      newTaskTitle.value = "";
      newTaskDescription.value = "";
      newTaskDueDate.value = "";
    };

    const deleteTask = (index) => {
      tasks.value.splice(index, 1);
      localStorage.setItem("tasks", JSON.stringify(tasks.value));
    };

    const deleteAllTasks = () => {
      tasks.value = [];
      localStorage.removeItem("tasks");
    };

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

    const saveTask = (task) => {
      task.title = task.editingValues.title;
      task.description = task.editingValues.description;
      task.dueDate = task.editingValues.dueDate;
      task.isEditing = false;
      delete task.editingValues;
      localStorage.setItem("tasks", JSON.stringify(tasks.value));
    };

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

    function formatDate(date) {
      if (!date) return '';
      return new Date(date).toLocaleDateString('de-DE');
    }

    const pendingTasks = computed(() => {
      return tasks.value.filter((x) => x.isDone === false).length;
    });

    onMounted(() => {
      if (localStorage.tasks) {
        tasks.value = JSON.parse(localStorage.getItem("tasks")) || [];
      }
    });

    return {
      newTaskTitle,
      newTaskDescription,
      newTaskDueDate,
      formattedDate,
      tasks,
      sortedTasks,
      pendingTasks,
      isMenuOpen,
      getTaskClass,
      addTask,
      deleteTask,
      deleteAllTasks,
      increaseDateBy1Day,
      decreaseDateBy1Day,
      startEditing,
      cancelEditing,
      saveTask,
      formatDate,
    };
  },
};
</script>
