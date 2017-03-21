<?php
/**
 * CSSPagination is a pagination class which combines with Cascading Style Sheet for good looking style; 
 * CSSPagination has main function to split all records before they will be loaded into one website, 
 * to be several records in one page (you can determine how many records in one page). 
 * So, if you want to jump at the other page, you can choose once of them. 
 * CSSPagination is easy to use and good looking. I try to throw the complexity code. 
 * The most important is, that you can change the CSS code to make it suitable with your own page style.
 */

class CSSPagination
{
	private $totalrows;
	private $rowsperpage;
	private $website;
	private $separate;
	private $page;
		
	public function __construct($totalrows, $rowsperpage, $website, $separate = '&')
	{
		$this->totalrows = $totalrows;
		$this->website = $website;
		$this->rowsperpage = $rowsperpage;
		$this->separate = $separate;
	}
	
	public function setPage($page)
	{
		if (!$page) { $this->page=1; } else  { $this->page = $page; }
	}
	
	public function getLimit()
	{
		return ($this->page - 1) * $this->rowsperpage;
	}
	
	private function getLastPage()
	{
		return ceil($this->totalrows / $this->rowsperpage);
	}
	
	public function showPage()
	{
		$pagination = "";
		$lpm1 = $this->getLastPage() - 1;
		$page = $this->page;
		$prev = $this->page - 1;
		$next = $this->page + 1;
		
		$pagination .= "<div>";
		$pagination .= "<ul class=\"pagination\">";
		
		
		
		if ($this->getLastPage() > 1)
		{
			if ($page > 1) 
				$pagination .= '<li><a rel="nofollow" href='.$this->website.$this->separate.'page='.$prev.'> <i class="fa fa-angle-left"></i> prev</a></li>';
			else
				$pagination .= '<li class="disabled"><a rel="nofollow" href="#"><i class="fa fa-angle-left"></i> prev</a></li>';
			
			
			if ($this->getLastPage() < 9)
			{	
				for ($counter = 1; $counter <= $this->getLastPage(); $counter++)
				{
					if ($counter == $page)
						$pagination .= ' <li class="active"><a rel="nofollow" href="#">'.$counter.'</a></li>';
					else
						$pagination .= '<li><a rel="nofollow\" href='.$this->website.$this->separate.'page='.$counter.'>'.$counter.'</a></li>';					
				}
			}
			
			elseif($this->getLastPage() >= 9)
			{
				if($page < 4)		
				{
					for ($counter = 1; $counter < 6; $counter++)
					{
						if ($counter == $page)
							$pagination .= "<li class=\"active\"><a rel=\"nofollow\" href=\"#\">".$counter."</a></li>";
						else
							$pagination .= '<li><a rel="nofollow" href="'.$this->website.$this->separate.'page='.$counter.'">'.$counter.'</a></li>';					
					}
					//$pagination .= "...";
					$pagination .= '<li><a rel="nofollow" href="'.$this->website.$this->separate.'page='.$lpm1.'">'.$lpm1.'</a></li>';
					$pagination .= '<li><a rel="nofollow" href="'.$this->website.$this->separate.'page='.$this->getLastPage().'">'.$this->getLastPage().'</a></li>';		
				}
				elseif($this->getLastPage() - 3 > $page && $page > 1)
				{
					$pagination .= '<li><a rel="nofollow" href="'.$this->website.$this->separate.'page=1">1</a></li>';
					$pagination .= '<li><a rel="nofollow" href="'.$this->website.$this->separate.'page=2">2</a></li>';
					//$pagination .= "...";
					for ($counter = $page - 1; $counter <= $page + 1; $counter++)
					{
						if ($counter == $page)
							$pagination .= "<li class=\"active\"><a rel=\"nofollow\" href=\"#\">".$counter."</a></li>";
						else
							$pagination .= '<li><a rel="nofollow" href="'.$this->website.$this->separate.'page='.$counter.'">'.$counter.'</a></li>';					
					}
					$pagination .= "<li><a rel=\"nofollow\" href='#'>...</a></li>";
					$pagination .= '<li><a rel="nofollow" href="'.$this->website.$this->separate.'page='.$lpm1.'">'.$lpm1.'</a></li>';
					$pagination .= '<li><a rel="nofollow" href="'.$this->website.$this->separate.'page='.$this->getLastPage().'">'.$this->getLastPage().'</a></li>';		
				}
				else
				{
					$pagination .= '<li><a rel="nofollow" href="'.$this->website.$this->separate.'page=1">1</a></li>';
					$pagination .= '<li><a rel="nofollow" href="'.$this->website.$this->separate.'page=2">2</a></li>';
					$pagination .= "<li><a rel=\"nofollow\" href='#'>...</a></li>";
					for ($counter = $this->getLastPage() - 4; $counter <= $this->getLastPage(); $counter++)
					{
						if ($counter == $page)
							$pagination .= "<li class=\"active\"><a rel=\"nofollow\" href=\"#\">".$counter."</a></li>";
						else
							$pagination .= '<li><a rel="nofollow" href="'.$this->website.$this->separate.'page='.$counter.'">'.$counter.'</a>';					
					}
				}
			}
		
		if ($page < $counter - 1) 
			$pagination .= '<li><a rel="nofollow" href="'.$this->website.$this->separate.'page='.$next.'">next <i class="fa fa-angle-right"></i></a></li>';
		else
			$pagination .= "<li class=\"disabled\"><a rel=\"nofollow\" href=\"#\">next <i class=\"fa fa-angle-right\"></i></a></li>";
		$pagination .= "</ul></div>\n";			
		}	
					
		return $pagination;
	}
}
?>