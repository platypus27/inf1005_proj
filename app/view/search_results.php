<div class = "card text-center">
<div id="search_header" class="card-header text-left" style="color:#FFC2C3; font-weight:bold;"> <b>search results</b> </div>
<?php
if(isset($data['search'])){
    if($data['search']!= 0){?>
      <div id="search_container">
        <div class="row p-5">
          <div class="col"><b>LoginID:</b></div>
          <div class="col"><b>Name:</b></div>
        </div>
    <?php
        foreach($data['search'] as &$results){
            $loginid= $results->getField('loginid')->getValue();
            $name = $results->getField('name')->getValue();
            ?>
              <div class = 'row p-3'>
                <div class="col"><?php echo "<a href=/tint/u/".$loginid.">".$loginid."</a>";?></div>
                <div class="col"><?php echo "<p>".$name."<p>";?></div>
              </div>  
            
      <?php }
    }  else{
      ?> <div class="card p-5"> <?php echo "<h3>user does not exist</h3>";?></div>
  <?php }
}
?>
</div>
</div>