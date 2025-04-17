<style>
	.autoshay_table tr:nth-child(2n) { background: #eeeeee; }
</style>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery(".autoshay_select_page .current-page").keypress(function(event){
			if(event.which == 13){
				var elem = jQuery(".autoshay_select_page");
				
				var page = (elem.find("input[name=page]").val());
				var paged = parseInt(elem.find("input[name=paged]").val());
				var count_page = parseInt(elem.find("input[name=count_page]").val());
				var orderby = elem.find("input[name=orderby]").val();
				var order = elem.find("input[name=order]").val();
				paged = count_page < paged ? count_page : paged;
				paged = paged < 1 ? 1 : paged;
				
				window.location.href = '<?php echo $url?>?page='+page+'&paged='+paged+'&orderby='+orderby+'&order='+order;
			}
		});
	});
</script>
<div class="wrap autoshay_table">
	<h1 class="wp-heading-inline"><?php echo $table_name;?></h1>
	<div class="tablenav top">
		<div class="tablenav-pages">
			<span class="displaying-num"><?php echo $count_row; ?> items</span>
			<span class="pagination-links">
		<?php	if($first){	?>
					<a class="first-page" href="<?php echo $first_url; ?>">
						<span class="screen-reader-text">First page</span>
						<span aria-hidden="true">«</span>
					</a>
		<?php	} else {	?>
					<span class="tablenav-pages-navspan" aria-hidden="true">«</span>				
		<?php	}	?>
		<?php	if($prev){	?>
					<a class="prev-page" href="<?php echo $prev_url; ?>">
						<span class="screen-reader-text">Previous page</span>
						<span aria-hidden="true">‹</span>
					</a>
		<?php	} else {	?>
					<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>				
		<?php	}	?>
				<span class="paging-input autoshay_select_page">
					<label for="current-page-selector" class="screen-reader-text">Current Page</label>
					<input type="hidden" name="page" value="<?php echo $page; ?>">
					<input type="hidden" name="orderby" value="<?php echo $orderby; ?>">
					<input type="hidden" name="order" value="<?php echo $order; ?>">
					<input type="hidden" name="count_page" value="<?php echo $count_page; ?>">
					<input class="current-page" name="paged" value="<?php echo $paged; ?>" size="1" aria-describedby="table-paging" type="text">
					<span class="tablenav-paging-text"> of <span class="total-pages"><?php echo $count_page; ?></span></span>
				</span>
		<?php	if($next){	?>
					<a class="next-page" href="<?php echo $next_url; ?>">
						<span class="screen-reader-text">Next page</span>
						<span aria-hidden="true">›</span>
					</a>
		<?php	} else {	?>
					<span class="tablenav-pages-navspan" aria-hidden="true">›</span>				
		<?php	}	?>
		<?php	if($last){	?>
					<a class="last-page" href="<?php echo $last_url; ?>">
						<span class="screen-reader-text">Last page</span>
						<span aria-hidden="true">»</span>
					</a>
		<?php	} else {	?>
					<span class="tablenav-pages-navspan" aria-hidden="true">»</span>				
		<?php	}	?>
			</span>
		</div>
	</div>
	<table class="wp-list-table widefat striped pages">
		<thead>
			<?php foreach($columns as $col){
				$order = $orderby == $col ? ($order == "asc" ? "desc" : "asc") : "asc";
				
				echo '<th id="'.$col.'" class="manage-column column-'.$col.' column-primary sortable '.$order.'" scope="col">
						<a href="'.$url.'?page=autoshay-table-'.$table_name.'&paged=1&orderby='.$col.'&order='.$order.'">
							<span title="'.$col.'">'.$col.'</span>
							<span class="sorting-indicator"></span>
						</a>
					</th>';
			}	?>
		</thead>
		<tbody>
			<?php 
				foreach($rows as $row){
					echo "<tr>";
					
					foreach($columns as $col)
						echo "<td>".$row[$col]."</td>";
						
					echo "</tr>";
				} 
			?>
		</tbody>
	</table>
	<div class="tablenav top">
		<div class="tablenav-pages">
			<span class="displaying-num"><?php echo $count_row; ?> items</span>
			<span class="pagination-links">
		<?php	if($first){	?>
					<a class="first-page" href="<?php echo $first_url; ?>">
						<span class="screen-reader-text">First page</span>
						<span aria-hidden="true">«</span>
					</a>
		<?php	} else {	?>
					<span class="tablenav-pages-navspan" aria-hidden="true">«</span>				
		<?php	}	?>
		<?php	if($prev){	?>
					<a class="prev-page" href="<?php echo $prev_url; ?>">
						<span class="screen-reader-text">Previous page</span>
						<span aria-hidden="true">‹</span>
					</a>
		<?php	} else {	?>
					<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>				
		<?php	}	?>
				<span class="paging-input autoshay_select_page">
					<label for="current-page-selector" class="screen-reader-text">Current Page</label>
					<input type="hidden" name="page" value="<?php echo $page; ?>">
					<input type="hidden" name="orderby" value="<?php echo $orderby; ?>">
					<input type="hidden" name="order" value="<?php echo $order; ?>">
					<input type="hidden" name="count_page" value="<?php echo $count_page; ?>">
					<input class="current-page" name="paged" value="<?php echo $paged; ?>" size="1" aria-describedby="table-paging" type="text">
					<span class="tablenav-paging-text"> of <span class="total-pages"><?php echo $count_page; ?></span></span>
				</span>
		<?php	if($next){	?>
					<a class="next-page" href="<?php echo $next_url; ?>">
						<span class="screen-reader-text">Next page</span>
						<span aria-hidden="true">›</span>
					</a>
		<?php	} else {	?>
					<span class="tablenav-pages-navspan" aria-hidden="true">›</span>				
		<?php	}	?>
		<?php	if($last){	?>
					<a class="last-page" href="<?php echo $last_url; ?>">
						<span class="screen-reader-text">Last page</span>
						<span aria-hidden="true">»</span>
					</a>
		<?php	} else {	?>
					<span class="tablenav-pages-navspan" aria-hidden="true">»</span>				
		<?php	}	?>
			</span>
		</div>
	</div>
<?php
	
?>
</div>