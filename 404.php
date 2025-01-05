<?php get_header(); ?>
<main class="content-wrap">
    

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
  <?php get_sidebar( 'primary' ); ?>
  <section class="content-area content-thin text-centered">
    <img class="alignnone size-medium image-404" src="<?php echo get_stylesheet_directory_uri() . "/media/denial-fox.png"?>" alt="" width="auto" height="512" usemap="#denialfox" />


    <map id="denialfox" name="denialfox">
    <area shape="rect" alt="" title="" coords="107,221,238,310" href="http://localhost/thestory.staging/" title="Go back" alt="Go back">
    <!-- Created by Online Image Map Editor (http://www.maschek.hu/imagemap/index) -->
    </map>
    <div class="label-404">
        <h1>404</h1>
        <h2>Not Found</h2>
        <h5>Tip: Click on the fox to go back</h5>
    </div>
  </section>
</main>
<?php get_footer(); ?>