
<!-- Html -->
<template>
  <div class="container d-flex justify-content-center align-items-center">
    <div class="card mt-3 col-6">
      <div class="card-body">
        <h1 class="text-center">Task List</h1>
        <div
            class="d-flex flex-column flex-sm-row justify-content-between mt-3 mt-sm-5"
        >
          <div class="col-sm-9">
            <input
                type="text"
                class="form-control"
                placeholder="Add a new task..."
                v-model="newTask"
                @keyup.enter="addTask"
                :disabled="tasks.length > 4"
            />
          </div>
          <div class="mt-3 mt-sm-0">
            <button
                type="button"
                class="btn btn-primary"
                @click="addTask"
                v-if="tasks.length <= 4"
            >
              Add
            </button>
            <p v-else class="message">List completed</p>
          </div>
        </div>
        <div class="mt-3 mt-sm-5">
          <div
              class="card item-card mt-2"
              v-for="(task, index) in tasks"
              :key="index"
          >
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <input
                    class="form-check-input"
                    type="checkbox"
                    v-model="task.isDone"
                />
                <div>
                  <p class="fw-semibold">{{ task.description }}</p>
                </div>
                <div>
                  <button
                      type="button"
                      class="btn btn-danger"
                      @click="deleteTask(index)"
                  >
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>
          <hr />
          <div class="d-flex flex-column flex-sm-row justify-content-between">
            <div>
              <p class="fw-bold" v-show="pendingTasks > 0">
                You have {{ pendingTasks }} pending tasks
              </p>
            </div>
            <div>
              <button
                  type="button"
                  class="btn btn-warning"
                  @click="deleteAllTasks"
                  v-show="tasks.length > 0"
              >
                Delete All
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<!-- Javascript -->
<script>
import { ref, onMounted, computed, watch } from "vue";

export default {
  name: "HomePage",
  setup() {
    const newTask = ref("");
    const tasks = ref([
      { description: "Review pending activities", isDone: false },
      { description: "Attend daily meetings", isDone: false },
    ]);

    const addTask = () => {
      if (!newTask.value) return;
      tasks.value.unshift({
        description: newTask.value,
        isDone: false,
      });
      localStorage.setItem("tasks", JSON.stringify(tasks.value));
      newTask.value = "";
    };

    const deleteTask = (index) => {
      tasks.value.splice(index, 1);
      localStorage.setItem("tasks", JSON.stringify(tasks.value));
    };

    const deleteAllTasks = () => {
      tasks.value = [];
      localStorage.removeItem("tasks");
    };

    const pendingTasks = computed(() => {
      return tasks.value.filter((x) => x.isDone === false).length;
    });

    watch(
        tasks,
        () => {
          if (tasks.value.length > 4) {
            alert('You have reached the maximum number of possible tasks (5)');
          }
        },
        { deep: true }
    );

    onMounted(() => {
      if (localStorage.tasks) {
        tasks.value = JSON.parse(localStorage.getItem("tasks")) || [];
      }
    });

    return {
      newTask,
      tasks,
      addTask,
      deleteTask,
      deleteAllTasks,
      pendingTasks,
    };
  },
};
</script>

  