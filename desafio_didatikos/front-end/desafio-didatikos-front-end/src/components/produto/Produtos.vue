<template>
  <div id="produtos-page">
    <h2>Produtos</h2>
    <p>
      Nesta página, você encontrará informações detalhadas sobre todas os
      produtos cadastrados no sistema.
    </p>
    <p>
      Você pode realizar buscas de produtos pelo nome de forma rápida e
      eficiente. Para adicionar uma nova marca, clique no botão abaixo e
      preencha as informações necessárias.
    </p>
    <button id="register-product-button" @click="goToRegister()">
      Registrar Produto
    </button>

    <div id="search-section">
      <p>Escolha o tipo de filtro e digite o termo de busca:</p>
      <select v-model="filterOption">
        <option value="nomeProduto">Nome Produto</option>
        <option value="marcaProduto">Nome Marca</option>
        <option value="cidade">Nome Cidade</option>
        <option value="intervaloPreco">Intervalo de Preço</option>
      </select>

      <div v-if="filterOption === 'intervaloPreco'" class="intervalo-preco">
        <p>
          Digite o preço mínimo e máximo nos campos abaixo para pesquisar
          produtos dentro de um intervalo de preço específico.
        </p>
        <input
          type="number"
          v-model.number="priceMin"
          placeholder="Preço mínimo"
        />
        <input
          type="number"
          v-model.number="priceMax"
          placeholder="Preço máximo"
        />
      </div>
      <div v-else>
        <p>
          Para pesquisar um produto pelo {{ getTextFilter(filterOption) }},
          digite o nome no campo de busca abaixo e atualize a lista
          automaticamente.
        </p>
        <input
          type="text"
          :placeholder="`Pesquisar por ${getTextFilter(filterOption)}`"
          v-model="searchQuery"
        />
      </div>
    </div>

    <p>
      Você pode clicar no nome de um produto para visualizar suas informações
      detalhadas. <br />
      Para excluir um produto, clique no ícone da lixeira. <br />
      Para editar as informações de um produto, clique no ícone de edição.
    </p>

    <p>
      Media dos valores dos produtos:
      {{ formatCurrency(calculateAverageValue()) }}
    </p>
    <p>
      Soma total dos valores dos produtos:
      {{ formatCurrency(calculateTotalValue()) }}
    </p>

    <table id="products-table">
      <thead>
        <tr>
          <th>Produto</th>
          <th>Editar</th>
          <th>Deletar</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in filteredProducts" :key="product.codProduto">
          <td @click="viewBranch(product.codProduto)" class="product-info">
            <div>Nome Produto: {{ product.nomeProduto }}</div>
            <div>Valor Produto: {{ formatCurrency(product.valorProduto) }}</div>
            <div>
              Marca Produto: {{ getBranchProduto(product.marcaProduto) }}
            </div>
            <div>Quantidade Estoque: {{ product.estoque }}</div>
            <div>Cidade Produto: {{ getCityProduct(product.cidade) }}</div>
          </td>
          <td class="action-column">
            <button class="edit-button" @click="editBranch(product.codProduto)">
              <ion-icon name="create-outline"></ion-icon>
            </button>
          </td>
          <td class="action-column">
            <button class="delete-button" @click="deleteProduct(product)">
              <ion-icon name="trash-outline"></ion-icon>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import api from "@/api/api";

export default {
  name: "ProdutosPage",
  data() {
    return {
      searchQuery: "",
      filterOption: "nomeProduto",
      priceMin: null,
      priceMax: null,
      branchs: [],
      cities: [],
      products: [],
    };
  },
  mounted() {
    this.fetchProducts();
    this.fetchBranchs();
    this.fetchCities();
  },
  computed: {
    filteredProducts() {
      if (this.filterOption === "nomeProduto") {
        return this.products.filter((product) =>
          product.nomeProduto
            .toLowerCase()
            .includes(this.searchQuery.toLowerCase())
        );
      } else if (this.filterOption === "marcaProduto") {
        return this.products.filter((product) => {
          const marca = this.branchs.find(
            (b) => b.codMarca === product.marcaProduto
          )?.nomeMarca;
          return marca?.toLowerCase().includes(this.searchQuery.toLowerCase());
        });
      } else if (this.filterOption === "cidade") {
        return this.products.filter((product) => {
          const cidade = this.cities.find(
            (c) => c.codCidade === product.cidade
          )?.nomeCidade;
          return cidade?.toLowerCase().includes(this.searchQuery.toLowerCase());
        });
      } else if (this.filterOption === "intervaloPreco") {
        return this.products.filter(
          (product) =>
            product.valorProduto >= (this.priceMin || 0) &&
            product.valorProduto <= (this.priceMax || Infinity)
        );
      }
      return this.products;
    },
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await api.getProdutos();
        this.products = response.data;
      } catch (error) {
        console.error("Error fetching products:", error);
      }
    },
    async fetchCities() {
      try {
        const response = await api.getCidades();
        this.cities = response.data;
      } catch (error) {
        console.error("Error fetching cities:", error);
      }
    },
    async fetchBranchs() {
      try {
        const response = await api.getMarcas();
        this.branchs = response.data;
      } catch (error) {
        console.error("Error fetching branchs:", error);
      }
    },
    viewBranch(codProduto) {
      this.$router.push({ name: "Produto", params: { id: codProduto } });
    },
    editBranch(codProduto) {
      this.$router.push({ name: "EditProduto", params: { id: codProduto } });
    },
    async deleteProduct(product) {
      if (product.estoque > 0) {
        alert(
          `Não é possível excluir o produto de código ${product.codProduto}, pois ele ainda possui estoque disponível. Apenas produtos com estoque igual a 0 podem ser removidos.`
        );
      } else {
        if (
          confirm(
            `Deseja realmente deletar a marca com ID: ${product.codProduto}?`
          )
        ) {
          try {
            const response = await api.deleteProduto(product.codProduto);
            this.products = this.products.filter(
              (product) => product.codProduto !== product.codProduto
            );
            alert("Produto deletado com sucesso!");
          } catch (error) {
            console.error("Ocorreu um erro ao deletar o produto:", error);
            alert(
              "Ocorreu um erro ao tentar deletar o produto. Tente novamente."
            );
          }
        } else {
          alert("Operação cancelada.");
        }
      }
    },
    getBranchProduto(branchId) {
      const branchFind = this.branchs.find(
        (branch) => branch.codMarca === branchId
      );
      return branchFind.nomeMarca;
    },
    getCityProduct(cityId) {
      const cityFind = this.cities.find((city) => city.codCidade === cityId);
      return cityFind.nomeCidade;
    },
    getTextFilter(filter) {
      let text;
      if (filter === "nomeProduto") {
        text = "nome do produto";
      } else if (filter === "marcaProduto") {
        text = "nome da marca";
      } else if (filter === "cidade") {
        text = "nome da cidade";
      }

      return text;
    },
    calculateTotalValue() {
      return this.products.reduce(
        (total, product) => total + product.valorProduto,
        0
      );
    },

    calculateAverageValue() {
      const total = this.calculateTotalValue();
      const count = this.products.length;
      return count > 0 ? total / count : 0;
    },
    formatCurrency(value) {
      if (!value) return "R$ 0,00";
      return `R$ ${value.toFixed(2).replace(".", ",")}`;
    },
    goToRegister() {
      this.$router.push({ name: "RegisterProduto" });
    },
  },
};
</script>

<style scoped>
#produtos-page {
  margin: 0 auto;
  padding: 20px;
  font-size: 16px;
  line-height: 1.6;
  text-align: left;
  box-sizing: border-box;
}

#register-product-button {
  background-color: #006eff;
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  margin: 20px 0;
  width: 100%;
}

#register-product-button:hover {
  background-color: #0056c7;
}

#search-section {
  margin: 20px 0;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
}

#search-section select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-bottom: 15px;
  font-size: 16px;
}

#search-section .intervalo-preco {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

#search-section input[type="number"] {
  flex: 1;
  min-width: 120px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
}

#search-section input[type="number"]::placeholder {
  color: #aaa;
}

#search-section input[type="text"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
  margin-top: 10px;
}

@media (max-width: 600px) {
  #search-section .intervalo-preco {
    flex-direction: column;
  }

  #search-section input[type="number"] {
    width: 100%;
  }
}

#products-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

#products-table th,
#products-table td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: left;
}

#products-table th {
  background-color: #f2f2f2;
  color: #000;
}

#products-table td.product-info {
  cursor: pointer;
  width: 100%;
  display: flex;
  flex-direction: column;
}

#products-table td.product-info:hover {
  cursor: pointer;
}

#products-table .action-column {
  width: 50px;
  text-align: center;
}

#products-table .edit-button ion-icon {
  font-size: 2rem;
  color: white;
}

#products-table .edit-button:hover ion-icon {
  color: darkgray;
}

#products-table .delete-button ion-icon {
  font-size: 2rem;
  color: red;
}

#products-table .delete-button:hover ion-icon {
  color: darkred;
}

#products-table button {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 16px;
}

#products-table button:hover {
  color: #006eff;
}
</style>
