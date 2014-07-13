<?php
	$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
        <ul class="pagination">
            <?php echo getPage::getPrevious($paginator->getCurrentPage(), $paginator->getUrl( $paginator->getCurrentPage()-1 ) ) ?>
            <?php echo getPage::getNext($paginator->getCurrentPage(), $paginator->getLastPage(), $paginator->getUrl( $paginator->getCurrentPage()+1 ) )  ?>
        </ul>
<?php endif; ?>

