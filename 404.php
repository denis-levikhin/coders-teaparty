<?php get_header(); ?>
<main class="content-wrap no-sidebar text-centered">
    

    <style>
        .label-404 > h1 {
            margin: 0;
        } 

        .label-404 > h2, 
        .label-404 > h5 {
            margin: .3em;
            margin-top: 0;
        }

        .content-area{
            flex-direction: row-reverse;
        }
    </style>
  <section class="content-area content-thin text-centered">
    <img class="alignnone size-medium image-404" src="<?php echo get_stylesheet_directory_uri() . "/media/denial-fox.png"?>" alt="" width="auto" height="512" usemap="#denialfox" />


    <map id="denialfox" name="denialfox">
    <area shape="rect" alt="" title="" coords="107,221,238,310" href="<?php echo get_site_url(); ?>" title="Go back" alt="Go back">
    <!-- Created by Online Image Map Editor (http://www.maschek.hu/imagemap/index) -->
    </map>
    <div class="label-404">
        <h1>404</h1>
        <h2>Not Found</h2>
        <div><strong>Tip: Click on the fox, or just <a href="<?php echo get_site_url(); ?>">go back</a></strong></div>
    </div>
  </section>
</main>
<?php get_footer(); ?>