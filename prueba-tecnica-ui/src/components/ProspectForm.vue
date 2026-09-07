<script setup>
import { ref } from 'vue'
import { useQuasar } from 'quasar'

// $q nos da acceso a los plugins de Quasar, como las notificaciones
const $q = useQuasar()

// Variables delformulario
const isLoading = ref(false)
const prospect = ref({
  name: '',
  phone: ''
})

const onSubmit = async () => {
  isLoading.value = true // Activa la animación de carga en el botón

  try {
    // Petición POST a la API de Laravel
    const response = await fetch('http://localhost:8000/api/prospects', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(prospect.value)
    })

    const data = await response.json()

    //si respuesta no es ok, lanza un error con el mensaje de Laravel
    if (!response.ok) {
      let errorMessage = 'Error al guardar el prospecto'
      
      if (response.status === 422 && data.errors) {
        errorMessage = Object.values(data.errors)[0][0]
      }
      
      throw new Error(errorMessage) // Lanzamos el error hacia el bloque catch
    }

    // Si todo sale bien (código 201)
    $q.notify({
      type: 'positive',
      message: 'Prospecto registrado exitosamente',
      position: 'top'
    })

    // Limpiar el formulario tras el éxito
    prospect.value = { name: '', phone: '' }

  } catch (error) {
    // Disparar notificación roja con el mensaje devuelto por Laravel
    $q.notify({
      type: 'negative',
      message: error.message,
      position: 'top'
    })
  } finally {
    isLoading.value = false // Detener el spinner del botón
  }
}
</script>

<template>
  <div class="q-pa-md row justify-center">
    <!-- q-form maneja la validación antes de disparar onSubmit -->
    <q-form @submit.prevent="onSubmit" class="col-12 col-md-6 q-gutter-md">
      
      <q-input
        filled
        v-model="prospect.name"
        label="Nombre completo *"
        lazy-rules
        :rules="[
          val => (val && val.length > 0) || 'El nombre es obligatorio'
        ]"
      />

      <q-input
        filled
        v-model="prospect.phone"
        label="Teléfono (10 dígitos) *"
        type="tel"
        lazy-rules
        :rules="[
          val => (val && val.length > 0) || 'El teléfono es obligatorio',
          val => /^[0-9]{10}$/.test(val) || 'Debe contener exactamente 10 números'
        ]"
      />

      <div class="text-right">
        <!-- :loading inmoviliza el botón y muestra un spinner si isLoading es true -->
        <q-btn
          label="Guardar Prospecto"
          type="submit"
          color="primary"
          :loading="isLoading"
        />
      </div>

    </q-form>
  </div>
</template>