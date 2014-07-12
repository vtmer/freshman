<?php
	$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
        <ul class="pagination">
            <?php echo getPrevious($paginator->getCurrentPage(), $paginator->getUrl( $paginator->getCurrentPage()-1 ) ) ?>
            <?php echo getNext($paginator->getCurrentPage(), $paginator->getLastPage(), $paginator->getUrl( $paginator->getCurrentPage()+1 ) )  ?>
        </ul>
<?php endif; ?>

<?php
function getPrevious($currentPage, $url)
{
    if ($currentPage <= 1)
        return '<li><a>上一页</a></li>';
    else
       return '<li><a href="'.$url.'">上一页</a></li>';
}

function getNext($currentPage, $lastPage, $url)
{
    if ($currentPage >= $lastPage)
        return '<li><a>下一页</a></li>';
    else
        return '<li><a href="'.$url.'">下一页</a></li>';
}
?>
