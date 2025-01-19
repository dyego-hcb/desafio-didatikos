<template>
  <div id="branch-page">
    <h2>
      {{ isEdit ? "Editar" : "Cadastrar Nova" }} Marca
      {{ isEdit ? this.branch.codMarca : "" }}
    </h2>
    <p>
      {{
        isEdit
          ? "Preencha o formulário abaixo para editar as informações da marca."
          : "Preencha o formulário abaixo para cadastrar uma nova marca."
      }}
    </p>

    <form @submit.prevent="isEdit ? saveEditBranch() : saveBranch()">
      <label for="nomemarca">Nome da Marca:</label>
      <input type="text" id="nomemarca" v-model="branch.nomeMarca" required />
      <label for="fabricante">Nome do Fabricante:</label>
      <input type="text" id="fabricante" v-model="branch.fabricante" required />

      <button type="submit" id="salvar-button">
        {{ isEdit ? "Salvar" : "Registrar" }}
      </button>
      <button type="button" id="voltar-button" @click="goBack()">Voltar</button>
    </form>
  </div>
</template>

<script>
import api from "@/api/api";

export default {
  name: "RegisterEditMarcaPage",
  props: ["id"],
  data() {
    return {
      branch: {},
      isEdit: !!this.id,
    };
  },
  mounted() {
    if (this.isEdit) {
      this.fetchBranch(this.id);
    }
  },
  methods: {
    saveBranch() {
      if (!this.branch.nomeMarca || this.branch.nomeMarca.trim() === "") {
        alert("O campo 'Nome da Marca' é obrigatório.");
        return;
      }
      if (!this.branch.fabricante || this.branch.fabricante.trim() === "") {
        alert("O campo 'Fabricante' é obrigatório.");
        return;
      }

      try {
        api
          .createMarca(this.branch)
          .then((response) => {
            alert(`Marca cadastrada com sucesso: ${response.data.nomeMarca}`);
            this.$router.push({ name: "Marcas" });
          })
          .catch((error) => {
            if (error.response) {
              if (error.response.status === 400) {
                const validationErrors = Object.values(
                  error.response.data.error
                ).flat();
                alert(
                  `Erro ao cadastrar a marca: ${validationErrors.join(", ")}`
                );
              } else if (error.response.status === 500) {
                alert("Erro interno do servidor. Tente novamente mais tarde.");
              } else {
                alert(
                  "Ocorreu um erro ao tentar cadastrar a marca. Tente novamente."
                );
              }
            } else {
              console.error("Erro ao cadastrar marca:", error);
              alert("Ocorreu um erro inesperado. Por favor, tente novamente.");
            }
          });
      } catch (error) {
        console.error("Error:", error);
      }
    },
    saveEditBranch() {
      if (!this.branch.nomeMarca || this.branch.nomeMarca.trim() === "") {
        alert("O campo 'Nome da Marca' é obrigatório.");
        return;
      }
      if (!this.branch.fabricante || this.branch.fabricante.trim() === "") {
        alert("O campo 'Fabricante' é obrigatório.");
        return;
      }

      try {
        api
          .updateMarca(this.id, this.branch)
          .then((response) => {
            alert(`Marca editada com sucesso: ${response.data.nomeMarca}`);
            this.$router.push({ name: "Marcas" });
          })
          .catch((error) => {
            if (error.response) {
              if (error.response.status === 400) {
                const validationErrors = Object.values(
                  error.response.data.error
                ).flat();
                alert(`Erro ao editar a marca: ${validationErrors.join(", ")}`);
              } else if (error.response.status === 500) {
                alert("Erro interno do servidor. Tente novamente mais tarde.");
              } else {
                alert(
                  "Ocorreu um erro ao tentar editar a marca. Tente novamente."
                );
              }
            } else {
              console.error("Erro ao editar marca:", error);
              alert("Ocorreu um erro inesperado. Por favor, tente novamente.");
            }
          });
      } catch (error) {
        console.error("Error:", error);
      }
    },
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

form {
  display: flex;
  flex-direction: column;
}

label {
  margin-bottom: 5px;
}

input {
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

#salvar-button {
  background-color: #28a745;
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  margin-bottom: 10px;
  width: 100%;
}

#salvar-button:hover {
  background-color: #218838;
}

#voltar-button {
  background-color: #006eff;
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  width: 100%;
  margin-top: 10px;
}

#voltar-button:hover {
  background-color: #0056c7;
}
</style>
