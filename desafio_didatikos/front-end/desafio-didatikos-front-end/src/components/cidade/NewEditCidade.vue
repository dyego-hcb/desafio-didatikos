<template>
  <div id="city-page">
    <h2>
      {{ isEdit ? "Editar" : "Cadastrar Nova" }} Cidade
      {{ isEdit ? this.city.codCidade : "" }}
    </h2>
    <p>
      {{
        isEdit
          ? "Preencha o formulário abaixo para editar as informações da cidade."
          : "Preencha o formulário abaixo para cadastrar uma nova cidade."
      }}
    </p>

    <form @submit.prevent="isEdit ? saveEditCity() : saveCity()">
      <label for="nomeCidade">Nome da Cidade:</label>
      <input type="text" id="nomeCidade" v-model="city.nomeCidade" required />

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
  name: "RegisterEditCidadePage",
  props: ["id"],
  data() {
    return {
      city: {},
      isEdit: !!this.id,
    };
  },
  mounted() {
    if (this.isEdit) {
      this.fetchCity(this.id);
    }
  },
  methods: {
    saveCity() {
      if (!this.city.nomeCidade || this.city.nomeCidade.trim() === "") {
        alert("O campo 'Nome da Cidade' é obrigatório.");
        return;
      }

      try {
        api
          .createCidade(this.city)
          .then((response) => {
            alert(`Cidade cadastrada com sucesso: ${response.data.nomeCidade}`);
            this.$router.push({ name: "Cidades" });
          })
          .catch((error) => {
            if (error.response) {
              if (error.response.status === 400) {
                const validationErrors = Object.values(
                  error.response.data.error
                ).flat();
                alert(
                  `Erro ao cadastrar a cidade: ${validationErrors.join(", ")}`
                );
              } else if (error.response.status === 500) {
                alert("Erro interno do servidor. Tente novamente mais tarde.");
              } else {
                alert(
                  "Ocorreu um erro ao tentar cadastrar a cidade. Tente novamente."
                );
              }
            } else {
              console.error("Erro ao cadastrar cidade:", error);
              alert("Ocorreu um erro inesperado. Por favor, tente novamente.");
            }
          });
      } catch (error) {
        console.error("Error:", error);
      }
    },
    saveEditCity() {
      if (!this.city.nomeCidade || this.city.nomeCidade.trim() === "") {
        alert("O campo 'Nome da Cidade' é obrigatório.");
        return;
      }

      try {
        api
          .updateCidade(this.id, this.city)
          .then((response) => {
            alert(`Cidade editada com sucesso: ${response.data.nomeCidade}`);
            this.$router.push({ name: "Cidades" });
          })
          .catch((error) => {
            if (error.response) {
              if (error.response.status === 400) {
                const validationErrors = Object.values(
                  error.response.data.error
                ).flat();
                alert(
                  `Erro ao editar a cidade: ${validationErrors.join(", ")}`
                );
              } else if (error.response.status === 500) {
                alert("Erro interno do servidor. Tente novamente mais tarde.");
              } else {
                alert(
                  "Ocorreu um erro ao tentar editar a cidade. Tente novamente."
                );
              }
            } else {
              console.error("Erro ao editar cidade:", error);
              alert("Ocorreu um erro inesperado. Por favor, tente novamente.");
            }
          });
      } catch (error) {
        console.error("Error:", error);
      }
    },
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
