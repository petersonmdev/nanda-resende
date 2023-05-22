<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nanda_Resende
 */

$range_price = getMinMaxPrice();
$search_filter = false;
$has_filter = false;
$filter = [];

if( !empty($_GET['categoria']) ){
    $search_filter = true;
    $has_filter = true;
    $filter['category'] = $_GET['categoria'];
    $product_cat = $filter['category'];
}

if( $_POST['has-filter'] == 'true' || is_product_category()){
    $has_filter = true;

	if(!empty($_POST['cat-filter'])){
		$filter['category'] = $_POST['cat-filter'];
		$product_cat = $filter['category'];
	} else if(get_query_var( 'term' )){
        $product_cat = get_query_var( 'term' );
    } else {
		$product_cat = null;
	}

	if(!empty($_POST['price-filter'])){
		$filter['price'] = $_POST['price-filter'];
		$price_filter = $filter['price'];
	}else{
		$price_filter = null;
	}
};

?>
<aside class="col-lg-3 col-12 filter-sidebar mb-4 pr-lg-0 filter-nandaresende">
	<form name="form-filter" id="form-filter" action="<?php echo esc_url(home_url('/loja')); ?>" method="post">

		<div class="content-filter-nandaresende <?php echo ($product_cat || $price_filter) ? 'filtro-ativado' : '' ?>">
		  <?php if ($product_cat || $price_filter || is_product_category()) { ?>
			<span class="text-center p-2 txt-filter-active">filtro ativado</span>
		  <?php } ?>
		  <div class="section-title toggle-categories text-center justify-content-center d-flex mt-3 mb-3">
			<h5 class="px-2"><?= ($product_cat || $price_filter || is_product_category()) ? 'Alterar filtro' : 'Filtrar'; ?></h5>
            <span class="material-symbols-outlined">tune</span>
		  </div>
		  <div class="p-3 mb-3 rounded content-minimal-filter">
		    <h4 class="subtitle-nandaresende mb-2">Categorias</h4>
		    <input type="hidden" name="cat-filter" value="<?php echo isset($filter['category']) ? $filter['category'] : '' ; ?>">
		    <ol id="cat-filter" class="d-lg-block d-none list-unstyled list-filter-nandaresende mb-2">
		        <?php $terms = get_terms( 'product_cat', array('hide_empty' => false, 'parent' => 0) );
		        foreach ( $terms as $term ) : ?>
		            <li>
                      <a class="cat-filter <?php echo ($filter['category'] == $term->slug) || ($product_cat == $term->slug) ? 'active' : ''; ?>" data-selected="<?php echo $term->slug ?>">
                          <?= $term->name ?><small><?= " (".$term->count.")" ?></small>
		              </a>
		            </li>
		        <?php endforeach; ?>
		    </ol>
              <div class="content-mobile">
                  <select class="d-lg-none col-md-12" id="cat-filter-select">
                      <option class="w-100" value="">Selecione uma categoria...</option>
                      <?php foreach ( $terms as $term ) : ?>
                          <option class="w-100" <?php echo ($filter['category'] == $term->slug) || ($product_cat == $term->slug) ? 'selected' : '' ; ?> value="<?= $term->slug ?>"><?= $term->name." (".$term->count.")" ?> </option>
                      <?php endforeach; ?>
                  </select>
              </div>
		   </div>

			<div class="p-3 mb-3 rounded content-minimal-filter">
				<h4 class="subtitle-nandaresende mb-2">Preço</h4>
				<div class="slidecontainer">
					<div class="row content-text-filter-price">
						<div class="col-6 text-left">
							<p>R$ <?php echo number_format($range_price['min'], 2, ',', ''); ?>
								<span style="display: block">Mínimo</span>
							</p>                          
						</div>
						<div class="col-6 text-right">
							<p>R$ <span id="valuePriceFilter"></span>
								<span style="display: block">Máximo</span>                            
							</p>
						</div>
					</div>
					<input type="range" name="price-filter" min="<?php echo number_format($range_price['min'], 2, '.', '') ?>" max="<?php echo number_format($range_price['max'], 2, '.', ''); ?>" value="<?php echo !empty($filter['price']) ? $price_filter : number_format($range_price['max'], 2, '.', ''); ?>" class="slider" id="filterPrice">
				</div>
			</div>
			<input type="hidden" name="has-filter" value="true">
		</div>
	</form>
	<form id="reset-filter" action="<?php echo esc_url( home_url('/loja')); ?>" method="post">
		<div class="mb-3 rounded" style="display: <?php echo $has_filter == true ? 'block' : 'none' ?>">
			<input type="hidden" name="has-filter" value="false">
			<button type="submit" class="btn btn-sm btn-default btn-block">Limpar Filtros</button>
		</div>
	</form>
</aside>

