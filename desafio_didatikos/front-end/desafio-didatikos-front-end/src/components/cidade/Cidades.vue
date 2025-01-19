<template>
  <div id="cities-page">
    <h2>Cidades</h2>
    <p>
      Nesta página, você encontrará informações detalhadas sobre todas as
      cidades cadastradas no sistema.
    </p>
    <p>
      Você pode realizar buscas de cidades pelo nome de forma rápida e
      eficiente. Para adicionar uma nova cidade, clique no botão abaixo e
      preencha as informações necessárias.
    </p>
    <button id="register-city-button" @click="goToRegister()">
      Registrar Cidade
    </button>

    <div id="search-section">
      <p>
        Para pesquisar uma cidade pelo nome, digite o nome no campo de busca
        abaixo e atualize a lista automaticamente.
      </p>
      <input
        type="text"
        placeholder="Pesquisar por nome da cidade"
        v-model="searchQuery"
      />
    </div>

    <p>
      Você pode clicar no nome de uma cidade para visualizar suas informações
      detalhadas. <br />
      Para excluir uma cidade, clique no ícone da lixeira. <br />
      Para editar as informações de uma cidade, clique no ícone de edição.
    </p>

    <table id="cities-table">
      <thead>
        <tr>
          <th>Cidade</th>
          <th>Editar</th>
          <th>Deletar</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="city in filteredCities" :key="city.codCidade">
          <td @click="viewCity(city.codCidade)" class="city-info">
            Nome Cidade: {{ city.nomeCidade }}
          </td>
          <td class="action-column">
            <button class="edit-button" @click="editCity(city.codCidade)">
              <ion-icon name="create-outline"></ion-icon>
            </button>
          </td>
          <td class="action-column">
            <button class="delete-button" @click="deleteCity(city.codCidade)">
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
  name: "CidadesPage",
  data() {
    return {
      searchQuery: "",
      cities: [],
    };
  },
  mounted() {
    this.fetchCities();
  },
  computed: {
    filteredCities() {
      return this.cities.filter((city) =>
        city.nomeCidade.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
  },
  methods: {
    async fetchCities() {
      try {
        const response = await api.getCidades();
        this.cities = response.data;
      } catch (error) {
        console.error("Error fetching cities:", error);
      }
    },
    viewCity(codCidade) {
      this.$router.push({ name: "Cidade", params: { id: codCidade } });
    },
    editCity(codCidade) {
      this.$router.push({ name: "EditCidade", params: { id: codCidade } });
    },
    async deleteCity(codCidade) {
      if (confirm(`Deseja realmente deletar a cidade com ID: ${codCidade}?`)) {
        try {
          const response = await api.deleteCidade(codCidade);
          this.cities = this.cities.filter(
            (city) => city.codCidade !== codCidade
          );
          alert("Cidade deletada com sucesso!");
        } catch (error) {
          console.error("Ocorreu um erro ao deletar a cidade:", error);
          alert("Ocorreu um erro ao tentar deletar a cidade. Tente novamente.");
        }
      } else {
        alert("Operação cancelada.");
      }
    },
    goToRegister() {
      this.$router.push({ name: "RegisterCidade" });
    },
  },
};
</script>

<style scoped>
#cities-page {
  margin: 0 auto;
  padding: 20px;
  font-size: 16px;
  line-height: 1.6;
  text-align: left;
}

#register-city-button {
  background-color: #006eff;
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  margin: 20px 0;
  width: 100%;
}

#register-city-button:hover {
  background-color: #0056c7;
}

#search-section {
  margin: 20px 0;
}

#search-section input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

#cities-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

#cities-table th,
#cities-table td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: left;
}

#cities-table th {
  background-color: #f2f2f2;
  color: #000;
}

#cities-table td.city-info {
  cursor: pointer;
  width: 100%;
}

#cities-table td.city-info:hover {
  cursor: pointer;
}

#cities-table .action-column {
  width: 50px;
  text-align: center;
}

#cities-table .edit-button ion-icon {
  color: white;
  font-size: 1.5rem;
}

#cities-table .edit-button:hover ion-icon {
  color: darkgray;
}

#cities-table .delete-button ion-icon {
  color: red;
  font-size: 1.5rem;
}

#cities-table .delete-button:hover ion-icon {
  color: darkred;
}

#cities-table button {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 16px;
}

#cities-table button:hover {
  color: #006eff;
}
</style>
