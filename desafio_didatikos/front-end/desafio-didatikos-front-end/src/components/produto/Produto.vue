<template>
  <div id="product-page">
    <h2>Informacão do Produto {{ product.codProduto }}</h2>
    <p>
      Nesta página, você encontrará informações detalhadas sobre um produto
      específico. Os detalhes estão listados abaixo. Para retornar à listagem
      completa de marcas, clique em "Produtos" na barra de navegação ou clikando
      no botão abaixo.
    </p>
    <button id="voltar-button" @click="goBack()">Voltar</button>

    <div>
      <p>Nome Produto: {{ product.nomeProduto }}</p>
      <p>Valor Produto: {{ formatCurrency(product.valorProduto) }}</p>
      <p>Marca Produto: {{ branch.nomeMarca }}</p>
      <p>Fabricante Produto: {{ branch.fabricante }}</p>
      <p>Quantidade Estoque: {{ product.estoque }}</p>
      <p>Cidade Produto: {{ city.nomeCidade }}</p>
    </div>
  </div>
</template>

<script>
import api from "@/api/api";

export default {
  name: "ProdutoPage",
  props: ["id"],
  data() {
    return {
      product: {},
      branch: {},
      city: {},
    };
  },
  mounted() {
    this.initializePage();
  },
  methods: {
    async initializePage() {
      try {
        await this.fetchProduct(this.id);
        if (this.product) {
          await this.fetchBranchProduto();
          await this.fetchCityProduto();
        }
      } catch (error) {
        console.error("Erro ao inicializar a página:", error);
      }
    },
    async fetchProduct(id) {
      try {
        const response = await api.getProdutoById(id);
        this.product = response.data;
      } catch (error) {
        console.error("Error fetching product:", error);
      }
    },
    formatCurrency(value) {
      if (!value) return "R$ 0,00";
      return `R$ ${value.toFixed(2).replace(".", ",")}`;
    },
    async fetchBranchProduto() {
      try {
        const response = await api.getMarcaById(this.product.marcaProduto);
        this.branch = response.data;
      } catch (error) {
        console.error("Error fetching branch:", error);
      }
    },
    async fetchCityProduto() {
      try {
        const response = await api.getCidadeById(this.product.cidade);
        this.city = response.data;
      } catch (error) {
        console.error("Error fetching branch:", error);
      }
    },
    goBack() {
      this.$router.push({ name: "Produtos" });
    },
  },
};
</script>

<style scoped>
#product-page {
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
