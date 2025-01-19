import { createRouter, createWebHistory } from "vue-router";

// PAGES
import HomePage from "@/components/home/Home.vue";
import ProdutosPage from "@/components/produto/Produtos.vue";
import ProdutoPage from "@/components/produto/Produto.vue";
import RegisterEditProductPage from "@/components/produto/NewEditProduct.vue";
import MarcasPage from "@/components/marca/Marcas.vue";
import MarcaPage from "@/components/marca/Marca.vue";
import RegisterEditMarcaPage from "@/components/marca/NewEditMarca.vue";
import CidadesPage from "@/components/cidade/Cidades.vue";
import CidadePage from "@/components/cidade/Cidade.vue";
import RegisterEditCidadePage from "@/components/cidade/NewEditCidade.vue";

const routes = [
  {
    path: "/",
    name: "Home",
    component: HomePage,
  },
  {
    path: "/produtos",
    name: "Produtos",
    component: ProdutosPage,
  },
  {
    path: "/produtos/:id",
    name: "Produto",
    component: ProdutoPage,
    props: true,
  },
  {
    path: "/produtos/new",
    name: "RegisterProduto",
    component: RegisterEditProductPage,
  },
  {
    path: "/produtos/edit/:id",
    name: "EditProduto",
    component: RegisterEditProductPage,
    props: true,
  },
  {
    path: "/marcas",
    name: "Marcas",
    component: MarcasPage,
  },
  {
    path: "/marcas/:id",
    name: "Marca",
    component: MarcaPage,
    props: true,
  },
  {
    path: "/marcas/new",
    name: "RegisterMarca",
    component: RegisterEditMarcaPage,
  },
  {
    path: "/marcas/edit/:id",
    name: "EditMarca",
    component: RegisterEditMarcaPage,
    props: true,
  },
  {
    path: "/cidades",
    name: "Cidades",
    component: CidadesPage,
  },
  {
    path: "/cidades/:id",
    name: "Cidade",
    component: CidadePage,
    props: true,
  },
  {
    path: "/cidades/new",
    name: "RegisterCidade",
    component: RegisterEditCidadePage,
  },
  {
    path: "/cidades/edit/:id",
    name: "EditCidade",
    component: RegisterEditCidadePage,
    props: true,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
