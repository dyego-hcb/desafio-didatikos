<template>
  <div id="product-page">
    <h2>
      {{ isEdit ? "Editar" : "Cadastrar Novo" }} Produto
      {{ isEdit ? this.product.codProduto : "" }}
    </h2>
    <p>
      {{
        isEdit
          ? "Preencha o formulário abaixo para editar as informações do produto."
          : "Preencha o formulário abaixo para cadastrar um novo produto."
      }}
    </p>

    <form @submit.prevent="isEdit ? saveEditProduct() : saveProduct()">
      <label for="nomeProduto">Nome do Produto:</label>
      <input
        type="text"
        id="nomeProduto"
        v-model="product.nomeProduto"
        required
      />

      <label for="valorProduto">Valor do Produto:</label>
      <input
        type="number"
        id="valorProduto"
        v-model="product.valorProduto"
        required
      />

      <label for="marcaProduto">Marca do Produto:</label>
      <input
        type="text"
        id="marcaProduto"
        v-model="selectedBrand"
        @input="filterBrands(selectedBrand)"
        required
      />
      <div v-if="brands.length > 0">
        <ul>
          <li
            v-for="brand in brands"
            :key="brand.id"
            @click="selectBrand(brand)"
          >
            {{ brand.nomeMarca }}
          </li>
        </ul>
      </div>
      <button
        v-if="brands.length === 0"
        @click="registerBrand()"
        id="new-itens-button"
      >
        Registrar Nova Marca
      </button>

      <label for="estoque">Quantidade em Estoque:</label>
      <input type="number" id="estoque" v-model="product.estoque" required />

      <label for="cidade">Cidade do Produto:</label>
      <input
        type="text"
        id="cidade"
        v-model="selectedCity"
        @input="filterCities(selectedCity)"
        required
      />
      <div v-if="cities.length > 0">
        <ul>
          <li v-for="city in cities" :key="city.id" @click="selectCity(city)">
            {{ city.nomeCidade }}
          </li>
        </ul>
      </div>
      <button
        v-if="cities.length === 0"
        @click="registerCity()"
        id="new-itens-button"
      >
        Registrar Nova Cidade
      </button>

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
  name: "RegisterEditProductPage",
  props: ["id"],
  data() {
    return {
      product: {},
      brands: [],
      cities: [],
      allBrands: [],
      allCities: [],
      selectedBrand: "",
      selectedCity: "",
      isEdit: !!this.id,
    };
  },
  mounted() {
    this.initializePage();
  },
  methods: {
    async initializePage() {
      try {
        await this.fetchBranchs();
        await this.fetchCitties();

        this.selectedBrand = "";
        this.selectedCity = "";

        if (this.isEdit) {
          await this.fetchProduct(this.id);
        }

        if (this.product) {
          this.selectedBrand = this.fetchBranchId(this.product.marcaProduto);
          this.selectedCity = this.fetchCityId(this.product.cidade);
        }

        this.filterCities(this.selectedCity);
        this.filterBrands(this.selectedBrand);
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
    async fetchBranchs() {
      try {
        const response = await api.getMarcas();
        this.allBrands = response.data;
      } catch (error) {
        console.error("Error fetching brands:", error);
      }
    },
    async fetchCitties() {
      try {
        const response = await api.getCidades();
        this.allCities = response.data;
      } catch (error) {
        console.error("Error fetching citties:", error);
      }
    },
    filterBrands(name) {
      this.brands = this.allBrands.filter((brand) =>
        brand.nomeMarca.toLowerCase().includes(name.toLowerCase())
      );
    },
    filterCities(name) {
      this.cities = this.allCities.filter((city) =>
        city.nomeCidade.toLowerCase().includes(name.toLowerCase())
      );
    },
    fetchBranchId(id) {
      const branchData = this.allBrands.filter(
        (brand) => brand.codMarca === id
      );

      return branchData.nomeMarca;
    },
    fetchCityId(id) {
      const cityData = this.allCities.filter((city) => city.codCidade === id);

      return cityData.nomeCidade;
    },
    selectBrand(brand) {
      this.product.marcaProduto = brand.codMarca;
      this.selectedBrand = brand.nomeMarca;
      this.brands = [brand];
    },
    selectCity(city) {
      this.product.cidade = city.codCidade;
      this.selectedCity = city.nomeCidade;
      this.cities = [city];
    },
    registerBrand() {
      this.$router.push({ name: "RegisterMarca" });
    },
    registerCity() {
      this.$router.push({ name: "RegisterCidade" });
    },
    saveProduct() {
      if (!this.product.nomeProduto || this.product.nomeProduto.trim() === "") {
        alert("O campo 'Nome do Produto' é obrigatório.");
        return;
      }
      if (!this.product.valorProduto || this.product.valorProduto < 0) {
        alert(
          "O campo 'Valor do Produto' é obrigatório e deve ser maior que 0."
        );
        return;
      }
      if (!this.product.marcaProduto) {
        alert("O campo 'Marca do Produto' é obrigatório.");
        return;
      }
      if (!this.product.estoque || this.product.estoque < 0) {
        alert("O campo 'Estoque' é obrigatório e deve ser maior que 0.");
        return;
      }
      if (!this.product.cidade) {
        alert("O campo 'Cidade do Produto' é obrigatório.");
        return;
      }

      try {
        api
          .createProduto(this.product)
          .then((response) => {
            alert(
              `Produto cadastrado com sucesso: ${response.data.nomeProduto}`
            );
            this.$router.push({ name: "Produtos" });
          })
          .catch((error) => {
            if (error.response) {
              if (error.response.status === 400) {
                const validationErrors = Object.values(
                  error.response.data.error
                ).flat();
                alert(
                  `Erro ao cadastrar o produto: ${validationErrors.join(", ")}`
                );
              } else if (error.response.status === 500) {
                alert("Erro interno do servidor. Tente novamente mais tarde.");
              } else {
                alert(
                  "Ocorreu um erro ao tentar cadastrar o produto. Tente novamente."
                );
              }
            } else {
              console.error("Erro ao cadastrar produto:", error);
              alert("Ocorreu um erro inesperado. Por favor, tente novamente.");
            }
          });
      } catch (error) {
        console.error("Error:", error);
      }
    },
    saveEditProduct() {
      if (!this.product.nomeProduto || this.product.nomeProduto.trim() === "") {
        alert("O campo 'Nome do Produto' é obrigatório.");
        return;
      }
      if (!this.product.valorProduto || this.product.valorProduto < 0) {
        alert(
          "O campo 'Valor do Produto' é obrigatório e deve ser maior que 0."
        );
        return;
      }
      if (!this.product.marcaProduto) {
        alert("O campo 'Marca do Produto' é obrigatório.");
        return;
      }
      if (!this.product.estoque || this.product.estoque < 0) {
        alert("O campo 'Estoque' é obrigatório e deve ser maior que 0.");
        return;
      }
      if (!this.product.cidade) {
        alert("O campo 'Cidade do Produto' é obrigatório.");
        return;
      }

      try {
        api
          .updateProduto(this.id, this.product)
          .then((response) => {
            alert(`Produto editado com sucesso: ${response.data.nomeProduto}`);
            this.$router.push({ name: "Produtos" });
          })
          .catch((error) => {
            if (error.response) {
              if (error.response.status === 400) {
                const validationErrors = Object.values(
                  error.response.data.error
                ).flat();
                alert(
                  `Erro ao editar o produto: ${validationErrors.join(", ")}`
                );
              } else if (error.response.status === 500) {
                alert("Erro interno do servidor. Tente novamente mais tarde.");
              } else {
                alert(
                  "Ocorreu um erro ao tentar editar o produto. Tente novamente."
                );
              }
            } else {
              console.error("Erro ao editar produto:", error);
              alert("Ocorreu um erro inesperado. Por favor, tente novamente.");
            }
          });
      } catch (error) {
        console.error("Error:", error);
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

ul {
  list-style: none;
  padding: 0;
}

ul li {
  padding: 10px;
  cursor: pointer;
  border-radius: 4px;
  margin-bottom: 5px;
  transition: background-color 0.3s;
}

ul li:hover {
  background-color: #f0f0f02c;
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

#new-itens-button {
  background-color: #af7303;
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  width: 100%;
  margin-top: 10px;
  margin-bottom: 10px;
}

#new-itens-button:hover {
  background-color: #d48c05;
}
</style>
