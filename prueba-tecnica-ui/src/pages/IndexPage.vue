<template>
  <q-page class="flex flex-center">
    
    <div class="text-center q-mb-lg">
      <h4 class="text-h4">Registro de Prospectos</h4>
      <p class="text-subtitle1">Ingresa los datos del nuevo cliente</p>
    </div>
    <!-- Inyección del componente -->
    <ProspectForm />
      
  </q-page>
</template>

<script setup>
// importa el componente ProspectForm
import ProspectForm from '../components/ProspectForm.vue'
</script>
