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


