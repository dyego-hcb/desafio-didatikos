<template>
  <div id="marcas-page">
    <h2>Marcas</h2>
    <p>
      Nesta página, você encontrará informações detalhadas sobre todas as marcas
      cadastradas no sistema.
    </p>
    <p>
      Você pode realizar buscas de marcas pelo nome de forma rápida e eficiente.
      Para adicionar uma nova marca, clique no botão abaixo e preencha as
      informações necessárias.
    </p>
    <button id="register-branch-button" @click="goToRegister()">
      Registrar Marca
    </button>

    <div id="search-section">
      <p>
        Para pesquisar uma marca pelo nome, digite o nome no campo de busca
        abaixo e atualize a lista automaticamente.
      </p>
      <input
        type="text"
        placeholder="Pesquisar por nome da marca"
        v-model="searchQuery"
      />
    </div>

    <p>
      Você pode clicar no nome de uma marca para visualizar suas informações
      detalhadas. <br />
      Para excluir uma marca, clique no ícone da lixeira. <br />
      Para editar as informações de uma marca, clique no ícone de edição.
    </p>

    <table id="branchs-table">
      <thead>
        <tr>
          <th>Marca</th>
          <th>Editar</th>
          <th>Deletar</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="branch in filteredBranchs" :key="branch.codMarca">
          <td @click="viewBranch(branch.codMarca)" class="branch-info">
            <div>Nome Marca: {{ branch.nomeMarca }}</div>
            <div>Nome Fabricante: {{ branch.fabricante }}</div>
          </td>
          <td class="action-column">
            <button class="edit-button" @click="editBranch(branch.codMarca)">
              <ion-icon name="create-outline"></ion-icon>
            </button>
          </td>
          <td class="action-column">
            <button
              class="delete-button"
              @click="deleteBranch(branch.codMarca)"
            >
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
  name: "MarcasPage",
  data() {
    return {
      searchQuery: "",
      branchs: [],
    };
  },
  mounted() {
    this.fetchBranchs();
  },
  computed: {
    filteredBranchs() {
      return this.branchs.filter((branch) =>
        branch.nomeMarca.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
  },
  methods: {
    async fetchBranchs() {
      try {
        const response = await api.getMarcas();
        this.branchs = response.data;
      } catch (error) {
        console.error("Error fetching branchs:", error);
      }
    },
    viewBranch(codMarca) {
      this.$router.push({ name: "Marca", params: { id: codMarca } });
    },
    editBranch(codMarca) {
      this.$router.push({ name: "EditMarca", params: { id: codMarca } });
    },
    async deleteBranch(codMarca) {
      if (confirm(`Deseja realmente deletar a marca com ID: ${codMarca}?`)) {
        try {
          const response = await api.deleteMarca(codMarca);
          this.branchs = this.branchs.filter(
            (branch) => branch.codMarca !== codMarca
          );
          alert("Marca deletada com sucesso!");
        } catch (error) {
          console.error("Ocorreu um erro ao deletar a marca:", error);
          alert("Ocorreu um erro ao tentar deletar a marca. Tente novamente.");
        }
      } else {
        alert("Operação cancelada.");
      }
    },
    goToRegister() {
      this.$router.push({ name: "RegisterMarca" });
    },
  },
};
</script>

<style scoped>
#marcas-page {
  margin: 0 auto;
  padding: 20px;
  font-size: 16px;
  line-height: 1.6;
  text-align: left;
}

#register-branch-button {
  background-color: #006eff;
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  margin: 20px 0;
  width: 100%;
}

#register-branch-button:hover {
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

#branchs-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

#branchs-table th,
#branchs-table td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: left;
}

#branchs-table th {
  background-color: #f2f2f2;
  color: #000;
}

#branchs-table td.branch-info {
  cursor: pointer;
  width: 100%;
  display: flex;
  flex-direction: column;
}

#branchs-table td.branch-info:hover {
  cursor: pointer;
}

#branchs-table .action-column {
  width: 50px;
  text-align: center;
}

#branchs-table .edit-button ion-icon {
  font-size: 1.5rem;
  color: white;
}

#branchs-table .edit-button:hover ion-icon {
  color: darkgray;
}

#branchs-table .delete-button ion-icon {
  font-size: 1.5rem;
  color: red;
}

#branchs-table .delete-button:hover ion-icon {
  color: darkred;
}

#branchs-table button {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 16px;
}

#branchs-table button:hover {
  color: #006eff;
}
</style>
