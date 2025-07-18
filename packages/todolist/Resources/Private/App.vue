<template>
  <button @click="sayHello">Klick mich</button>
</template>

<script setup>
function sayHello() {
  alert('Hallo Welt')
}
</script>