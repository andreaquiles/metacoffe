<?php

/**
 * @version 0.0.1
 */
?>
<?php

class paginadorHTML {

    private $page, $url, $urlQry;
    private $pages;
    private $count;
    private $limit;

    public function paginadorHTML($page, $count, $limit = 25, $url = '', $urlQry = array()) {
        $this->url = $url;
        $this->count = $count;
        $this->limit = $limit;
        $this->pages = ceil($this->count / $this->limit);
        $this->setPage($page);
        $this->urlQry = $urlQry;
    }

    private function setPage($page) {
        if ($page >= 1 && $page <= $this->pages && is_numeric($page)) {
            $this->page = $page; // it´s ok :)
        } else {
            $this->page = 1;
        }
    }

    public function getPage() {
        return (($this->page - 1) * $this->limit) . ', ' . $this->limit;
    }

    public function getPagi() {

        $return = '';

        if ($this->pages > 0) {

            if ($this->page < 5) {
                $s1 = 1;
                $s2 = 9;
            } elseif ($this->page > ($this->pages - 4)) {
                if (($this->pages - 8) <= 1) {
                    $s1 = 1;
                } else {
                    $s1 = ($this->pages - 8);
                }
                $s2 = ($this->pages);
            } else {
                $s1 = ($this->page - 4);
                $s2 = ($this->page + 4);
            }

            $return = '<div class="b-items__pagination-main wow zoomInUp" data-wow-delay="0.5s">';
            if ($this->page > 1) {
                $return .= '<a data-target="" href="' . $this->url . '?' . http_build_query(array_merge(array('page' => ($this->page - 1)), $this->urlQry)) . '" class="m-left"><span class="fa fa-angle-left"></span></a>';
            } else {
                $return .= '<a data-target="" href="#" class="m-left"><span class="fa fa-angle-left"></span></a>';
                
            }

            for ($i = $s1; $i <= $this->pages; $i++) {
                if ($i == $this->page) {
                    $return .='<span class="m-active"><a href="javascript:void(0);">' . $i . '</a></span>';
                } else {
                    $return .='<span class="m-active"><a href=href="' . $this->url . '?' . http_build_query(array_merge(array('page' => $i), $this->urlQry)) . '">' . $i . '</a></span>';
                    
                }
                if ($i >= $s2)
                    break;
            }

            if ($this->page < $this->pages) {
                $return .= '<a data-target="" ref="' . $this->url . '?' . http_build_query(array_merge(array('page' => ($this->page + 1)), $this->urlQry)) . '" class="m-right"><span class="fa fa-angle-right"></span></a>';
            } else {
                $return .= '<a data-target="" href="#" class="m-right"><span class="fa fa-angle-right"></span></a>';
            }
            $return .= '</div>';
        }
        return $return;
    }

    public function getInfo() {
        if ($this->pages > 0) {
            /*
              $return = '<div class="alert alert-info text-center">';
              $return .= 'Página ' . $this->page . ' de ' . $this->pages . ' ( ' . $this->count . ' - Registros encontrados )';
              $return .= '</div>';
             */
            //$return = '<p class="text-info text-right">';
            $return .= 'Página ' . $this->page . ' de ' . $this->pages . ' ( ' . $this->count . ' - Registros encontrados )';
            //$return .= '</p>';
        } else {

            //$return = '<div class="alert alert-warning text-center">';
            $return .= 'Nenhum registro encontrado';
            //$return .= '</div>';
            /*
              $return = '<p class="text-warning text-right">';
              $return .= 'Nenhum registro encontrado';
              $return .= '</p>';
             */
        }
        return $return;
    }

}

?>