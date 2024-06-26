<?php  
/*
 * Theme Name:        La Tienda de Nianne WooCommerce
 * Description:       Tema personalizado para la tienda virtual "La tienda de Nianne"
 * Author:            Isabel León
 * Template:          Storefront
 * Version:           1.0.0
 * License:           GPL v2 or later
 * Tags:              WooCommerce, Spa, Responsive
 */

/*Elimina el título del "single_product" 
 remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
*/

//Cambiar símbolo moneda a euro
function tiendaNianne_EUR($simbolo, $moneda){
    $simbolo = 'EUR €';
    return $simbolo;
}
add_filter('woocommerce_currency_symbol', 'tiendaNianne_EUR', 10, 2);


//Modificar los datos del footer
function tiendaNianne_nuevo_footer(){
    echo "<div class='reservados'>";
    echo "&copy; " . get_the_date('Y') . " " . get_bloginfo('name');
    echo "<br>";
    echo "<p> Todos los derechos reservados </p>";
    echo "</div>";
}

//Elimina el footer por defecto y añade tiendaNianne_nuevo_footer
function tiendaNianne_creditos(){
    remove_action('storefront_footer', 'storefront_credit', 20);
    add_action( 'storefront_footer', 'tiendaNianne_nuevo_footer', 20);
}
add_action( 'init', 'tiendaNianne_creditos');


//Añade banner código descuento
function tiendaNianne_cupon(){
    $imagen = '<div class= "cupon">';
    $imagen .='<img src="' . get_stylesheet_directory_uri( ) . '/img/cupon.png">';
    $imagen .= '</div>';
    echo $imagen;
}

//Banner se muestra SÓLO en la TIENDA (y INICIO), encima del título. No se muestra en el BLOG, ni en NOSOTROS, ni en MI CUENTA
add_action('woocommerce_before_main_content', 'tiendaNianne_cupon', 9);


//Cambiar texto de uno de los filtros
function tiendaNianne_sort($filtro){
    $filtro['date'] = __('Nuevos productos primero', 'woocommerce');
    return $filtro;
}
add_filter('woocommerce_catalog_orderby', 'tiendaNianne_sort', 40 );


/*Eliminar Tab "description" del producto
function tiendaNianne_tabs($tabs){
     unset($tabs['description']);
     return $tabs;
}
add_filter('woocommerce_product_tabs', 'tiendaNianne_tabs', 11, 1);*/

//Cambiar Tab Descripción por el título del Producto
function tiendaNianne_titulo_tab_descripcion($tabs) {
    global $post;
    if(isset($tabs['description']['title'])){
        $tabs['description']['title'] = $post->post_title;
    }
    return $tabs;
}
add_filter('woocommerce_product_tabs', 'tiendaNianne_titulo_tab_descripcion', 10, 1);


//Reemplaza el título del contenido del Tab por el nombre del producto
function tiendaNianne_titulo_contenido_tab($titulo){
    global $post;
    return $post-> post_title;
}
add_filter('woocommerce_product_description_heading', 'tiendaNianne_titulo_contenido_tab', 10, 1);


//Muestra una imagen del producto por defecto
function tiendaNianne_imagen_prod_default($imagen_url){
    $imagen_url = get_stylesheet_directory_uri( ) . '/img/logoNianne.png';
    return $imagen_url;
}
add_filter('woocommerce_placeholder_img_src', 'tiendaNianne_imagen_prod_default');

//Muestra enlace a las entradas del Blog
function tiendaNianne_mostrar_entradas_blog(){
    $args = array(
        'post_type' => 'post',
        'post_per_page' => 1,
        'orderby' => 'date',
        'order' => 'desc'
    );
    $entradas = new WP_Query($args);?>

<div class="entradas-blog">
    <h2 class="section-title"> Últimas entradas del blog </h2>
    <ul>
        <?php while ($entradas->have_posts()): $entradas->the_post(); ?>
            
            <li> 
                <?php the_title('<h3>', '</h3>'); ?> 
                <div class="contenido-entrada"> 
                    <header class="encabezado-entrada">
                        <p>Autor: <?php the_author(); ?> | <?php the_time(get_option('date_format')); ?> </p>
                    </header>

                    <?php 
                    //Definimos la cantidad de palabras del contenido del post que se van a mostrar
                    $contenido = wp_trim_words(get_the_content(), 20);
                    echo $contenido;
                    ?>
                    <a href="<?php the_permalink(); ?>" class="enlace-entrada"> Leer más </a>
                </div>
            </li>

        <?php endwhile;  wp_reset_postdata(); ?>
       
    </ul>
</div>
    



<?php
}
add_action( 'woocommerce_after_shop_loop', 'tiendaNianne_mostrar_entradas_blog', 80);