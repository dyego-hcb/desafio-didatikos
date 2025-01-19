import axios from "axios";

const api = axios.create({
  baseURL: "process.env.URL_API_BACK_END",
  headers: {
    "Content-Type": "application/json",
  },
});

export default {
  // PRODUTOS ROUTES
  getProdutos() {
    return api.get("/produtos/getAll");
  },
  getProdutoById(id) {
    return api.get(`/produtos/get/${id}`);
  },
  createProduto(data) {
    return api.post("/produtos/register", data);
  },
  updateProduto(id, data) {
    return api.put(`/produtos/edit/${id}`, data);
  },
  deleteProduto(id) {
    return api.delete(`/produtos/delete/${id}`);
  },
  // CIDADES ROUTES
  getCidades() {
    return api.get("/cidade/getAll");
  },
  getCidadeById(id) {
    return api.get(`/cidade/get/${id}`);
  },
  createCidade(data) {
    return api.post("/cidade/register", data);
  },
  updateCidade(id, data) {
    return api.put(`/cidade/edit/${id}`, data);
  },
  deleteCidade(id) {
    return api.delete(`/cidade/delete/${id}`);
  },
  // MARCAS ROUTES
  getMarcas() {
    return api.get("/marca/getAll");
  },
  getMarcaById(id) {
    return api.get(`/marca/get/${id}`);
  },
  createMarca(data) {
    return api.post("/marca/register", data);
  },
  updateMarca(id, data) {
    return api.put(`/marca/edit/${id}`, data);
  },
  deleteMarca(id) {
    return api.delete(`/marca/delete/${id}`);
  },
};
