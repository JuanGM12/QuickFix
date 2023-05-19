<style>
.contenedor {
    width: 95%;
    max-width: 120rem; /** = 1200px; **/
    margin: 0 auto;
}
.site-footer {
    background-color: #333333;
    margin: 0;
}
.contenedor-footer {
    padding: 3rem 0;
    text-align: center;
}
@media (min-width: 768px) {
    .contenedor-footer {
        display: flex;
        justify-content: space-between;
    }
}
.site-footer nav {
    display: none;
}
@media (min-width: 768px) {
    .site-footer nav {
        display: block;
    }
}
.navegacion a {
    color: #ffffff;
    text-decoration: none;
    font-size: 2.2rem;
    display: block;
}
@media (min-width: 768px) {
    .navegacion a {
        display: inline-block;
        font-size: 1.2rem !important; /** = 18px **/
        margin-right: 2rem !important;
    }
    .navegacion a:last-of-type {
        margin: 0;
    }
}
.navegacion a:hover {
    color: #71B100;
}
</style>  
   
<footer class="site-footer seccion">
	<div class="app-wrapper">
		<div class="contenedor contenedor-footer">
			<nav class="navegacion">
				<a href="servicios">Todos los Servicios</a>
				<a href="contacto">Contacto</a>
			</nav>
			<p class="copyright">Todos los Derechos Reservados - QuickFix 2023 &copy; </p>
		</div>
	</div>
</footer>
