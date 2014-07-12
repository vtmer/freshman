
<?php
	$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);

	$trans = $environment->getTranslator();
?>

<?php if ($paginator->getLastPage() > 1): ?>
        <ul class="pagination">
		<?php
			echo $presenter->getPrevious($trans->trans('上一页'));

			echo $presenter->getNext($trans->trans('下一页'));
		?>
        </ul>
<?php endif; ?>
