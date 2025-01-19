<template>
  <div id="home-page">
    <h1>Bem-vindo ao Sistema de Gerenciamento de Produtos</h1>

    <div id="sobre">
      <h2>Sobre o Projeto</h2>

      <p>
        Este projeto foi desenvolvido para facilitar o gerenciamento de
        produtos, cidades e marcas, oferecendo uma interface intuitiva e
        eficiente. A aplicação permite que você controle seus dados de maneira
        prática e segura, com funcionalidades como filtros dinâmicos, validações
        e operações completas de cadastro, edição e exclusão.
      </p>

      <h3>Funcionalidades Principais</h3>
      <ul>
        <li>
          <strong>Gerenciamento de Produtos:</strong> Cadastrar, editar e
          excluir produtos com validações completas. <br />
          Filtrar produtos por valor (intervalo), cidade ou exibir a soma/média
          dos valores. <br />
          Restrições de exclusão para produtos com estoque disponível.
        </li>
        <li>
          <strong>Gerenciamento de Cidades e Marcas:</strong> Cadastrar novas
          cidades e marcas de forma simples. <br />
          Atualizar e excluir informações diretamente pela interface.
        </li>
      </ul>

      <h3>Navegação</h3>
      <p>
        Na barra de navegação (nav-bar) da aplicação, você encontrará as opções:
      </p>
      <ul>
        <li>
          Produtos: Clique para listar, filtrar ou gerenciar os produtos
          cadastrados.
        </li>
        <li>
          Cidades: Gerencie as cidades registradas, incluindo criação, edição e
          exclusão.
        </li>
        <li>
          Marcas: Cadastre novas marcas, edite informações existentes ou remova
          registros.
        </li>
      </ul>

      <h3>Sobre o Projeto</h3>
      <p>
        Backend: Desenvolvido com Laravel e banco de dados MySQL para garantir
        robustez e escalabilidade.
      </p>
      <p>
        Frontend: Criado com Vue.js para uma experiência de usuário moderna e
        interativa.
      </p>
      <p>
        Melhores Práticas: O código segue princípios de Clean Code e S.O.L.I.D.,
        assegurando qualidade e manutenção a longo prazo.
      </p>
      <p>
        Testes Unitários: Incluídos para validar a funcionalidade do sistema e
        garantir confiabilidade.
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: "HomePage",
};
</script>

<style scoped>
#home-page {
  margin: 0 auto;
  padding: 20px;
  font-size: 16px;
  line-height: 1.6;
  text-align: left;
}

h1 {
  text-align: left;
}

h2 {
  text-align: left;
}

h3 {
  text-align: left;
}

p {
  text-align: left;
}

ul {
  text-align: left;
  padding-left: 20px;
}

li {
  margin-bottom: 10px;
}
</style>
