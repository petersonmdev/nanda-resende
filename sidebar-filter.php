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

if( $_POST['has-filter'] == 'true' ){
    $has_filter = true;

	if(!empty($_POST['cat-filter'])){
		$filter['category'] = $_POST['cat-filter'];
		$product_cat = $filter['category'];
	}else{
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

<aside class="col-3 d-lg-block d-none filter-sidebar filter-nandaresende">
	<form name="form-filter" id="form-filter" action="<?php echo esc_url(home_url('/loja')); ?>" method="post">
		<div class="content-filter-nandaresende <?php echo ($product_cat || $price_filter) ? 'filtro-ativado' : '' ?>">
		  <?php if ($product_cat || $price_filter) { ?>
			<span class="text-center p-2 txt-filter-active">filtro ativado</span>
		  <?php } ?>
		  <div class="section-title text-center mt-3 mb-3">
			<h5>Filtros</h5>
		  </div>
		  <div class="p-3 mb-3 rounded">
		    <h4 class="subtitle-nandaresende mb-2">Categorias</h4>
		    <input type="hidden" name="cat-filter" value="<?php echo isset($filter['category']) ? $filter['category'] : '' ; ?>">
		    <ol id="cat-filter" class="list-unstyled list-filter-nandaresende mb-2">
		        <?php $terms = get_terms( 'product_cat', array('hide_empty' => false, 'parent' => 0) );
		        foreach ( $terms as $term ) : ?>
		            <li>
		              <a class="cat-filter <?php echo ($filter['category'] == $term->slug) || ($product_cat == $term->slug) ? 'active' : ''; ?>" data-selected="<?php echo $term->slug ?>">
		                <?php echo $term->name ?>                                
		              </a>
		            </li>
		        <?php endforeach; ?>
		    </ol>
		   </div>

			<div class="p-3 mb-3 rounded">
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

<script type="text/javascript">
	var slider = document.getElementById("filterPrice");
	var output = document.getElementById("valuePriceFilter");
	output.innerHTML = slider.value;

	slider.oninput = function() {
	output.innerHTML = this.value;
	};


	jQuery(document).ready(function(){
		$(".cat-filter").click(function(e){
            e.preventDefault();
            $("#cat-filter li > a").removeClass("active");
            $(this).addClass("active");
            var category = $(this).attr('data-selected');
            $("input[name=cat-filter]").val(category);

            $("#form-filter").submit();
		});
		$(".color-filter").click(function(e){
            e.preventDefault();
            $("#color-filter li > a").removeClass("active");
            $(this).addClass("active");
            var color = $(this).attr('data-selected');
            $("input[name=color-filter]").val(color);

            $("#form-filter").submit();
		});
		$("#filterPrice").change(function(event) {
		    $("#form-filter").submit();
		});
	});
</script>