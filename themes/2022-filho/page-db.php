<?php
/**
 * Template Name: Modelo DB
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

    $conn = mysqli_connect(getenv_docker('WORDPRESS_DB_HOST', 'mysql'),'','','recruitment');

    if($conn === false){
        die("Erro: " . mysqli_connect_error());
    }
    
    switch($_GET['acao']){
        default:
            require('lista.php');
    }
 