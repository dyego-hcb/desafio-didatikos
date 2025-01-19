<template>
  <nav class="navbar">
    <div class="navbar-right">
      <span>Desafio Didatikos</span>
    </div>

    <div class="navbar-left">
      <a href="/" class="nav-item">Home</a>
      <a href="/produtos" class="nav-item">Produtos</a>
      <a href="/marcas" class="nav-item">Marcas</a>
      <a href="/cidades" class="nav-item">Cidades</a>
    </div>
  </nav>
</template>

<script>
export default {
  name: "Navbar",
};
</script>

<style scoped>
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
  background-color: #006eff;
  color: white;
  position: sticky;
  top: 0;
  z-index: 1000;
}

.navbar-left,
.navbar-right {
  display: flex;
  align-items: center;
}

.navbar-left .nav-item,
.navbar-right span {
  margin: 0 10px;
  color: white;
  text-decoration: none;
  font-size: 16px;
  display: flex;
  align-items: center;
}

.navbar-left .nav-item:hover {
  text-decoration: none;
  cursor: pointer;
}

.navbar-right span {
  text-align: right;
}
</style>
