<template>
  <div id="city-page">
    <h2>Informacão da Cidade {{ city.codCidade }}</h2>
    <p>
      Nesta página, você encontrará informações detalhadas sobre uma cidade
      específica. Os detalhes estão listados abaixo. Para retornar à listagem
      completa de cidades, clique em "Cidades" na barra de navegação ou clikando
      no botão abaixo.
    </p>
    <button id="voltar-button" @click="goBack()">Voltar</button>

    <div>
      <p>Nome da Cidade: {{ city.nomeCidade }}</p>
    </div>
  </div>
</template>

<script>
import api from "@/api/api";

export default {
  name: "CidadePage",
  props: ["id"],
  data() {
    return {
      city: {},
    };
  },
  mounted() {
    this.fetchCity(this.id);
  },
  methods: {
    async fetchCity(id) {
      try {
        const response = await api.getCidadeById(id);
        this.city = response.data;
      } catch (error) {
        console.error("Error fetching city:", error);
      }
    },
    goBack() {
      this.$router.push({ name: "Cidades" });
    },
  },
};
</script>

<style scoped>
#city-page {
  margin: 0 auto;
  padding: 20px;
  font-size: 16px;
  line-height: 1.6;
  text-align: left;
}

#voltar-button {
  background-color: #006eff;
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  margin: 20px 0;
  width: 100%;
}

#voltar-button:hover {
  background-color: #0056c7;
}
</style>
