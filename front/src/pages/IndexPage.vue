<template>
  <q-page class="">
    <div class="col-12">
      <q-btn type="button" label="Click"  @click="factura" class="full-width" color="red" />
    </div>
<!--    <img-->
<!--      alt="Quasar logo"-->
<!--      src="~assets/quasar-logo-vertical.svg"-->
<!--      style="width: 200px; height: 200px"-->
<!--    >-->
    <q-form @click="sincronizar">
    <div class="row">
      <div class="col-12"><q-input v-model="dato.url" label="url" dense outlined /></div>
      <div class="col-12"><q-input v-model="dato.codigoAmbiente" label="codigoAmbiente" dense outlined /></div>
      <div class="col-12"><q-input v-model="dato.codigoModalidad" label="codigoModalidad" dense outlined /></div>
      <div class="col-12"><q-input v-model="dato.codigoPuntoVenta" label="codigoPuntoVenta" dense outlined /></div>
      <div class="col-12"><q-input v-model="dato.codigoSistema" label="codigoSistema" dense outlined /></div>
      <div class="col-12"><q-input v-model="dato.codigoSucursal" label="codigoSucursal" dense outlined /></div>
      <div class="col-12"><q-input v-model="dato.cuis" label="cuis" dense outlined /></div>
      <div class="col-12"><q-input v-model="dato.nit" label="nit" dense outlined /></div>
      <div class="col-12">
        <q-btn type="submit" label="Click" class="full-width" color="primary" />
      </div>

    </div>
    </q-form>
  </q-page>
</template>

<script>
// import { defineComponent } from 'vue'

export default {
  name: `IndexPage`,
  data(){
    return {
      dato:{
        "url":"https://pilotosiatservicios.impuestos.gob.bo/v2/ServicioFacturacionCompraVenta",
        "codigoAmbiente" :2,
        "codigoModalidad":1,
      "codigoPuntoVenta" :1,
      "codigoSistema" :"720C9398D1070CD354C6AC6",
      "codigoSucursal" :0,
      "cuis" :"2D7D3CB2",
      "nit" :3102229014,
      }
    }
  },
  methods:{
    sincronizar(){
      this.$api.post('http://localhost:8000/api/siat',this.dato).then(res=>{
        console.log(res.data)
      })
    },
    factura(){
      this.$api.post('http://localhost:8000/api/factura',this.dato).then(res=>{
        console.log(res.data)
      })
    }
  }
}
</script>
