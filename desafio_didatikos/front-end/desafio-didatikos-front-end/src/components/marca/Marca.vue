<template>
  <div id="branch-page">
    <h2>Informacão da Marca {{ branch.codMarca }}</h2>
    <p>
      Nesta página, você encontrará informações detalhadas sobre uma marca
      específica. Os detalhes estão listados abaixo. Para retornar à listagem
      completa de marcas, clique em "Marcas" na barra de navegação ou clikando
      no botão abaixo.
    </p>
    <button id="voltar-button" @click="goBack()">Voltar</button>

    <div>
      <p>Nome da Marca: {{ branch.nomeMarca }}</p>
      <p>Nome da Fornecedor: {{ branch.fabricante }}</p>
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
      branch: {},
    };
  },
  mounted() {
    this.fetchBranch(this.id);
  },
  methods: {
    async fetchBranch(id) {
      try {
        const response = await api.getMarcaById(id);
        this.branch = response.data;
      } catch (error) {
        console.error("Error fetching branch:", error);
      }
    },
    goBack() {
      this.$router.push({ name: "Marcas" });
    },
  },
};
</script>

<style scoped>
#branch-page {
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
