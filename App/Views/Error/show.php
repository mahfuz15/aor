<?php //pr($this->values);
     /*   pr($this->request->flashMessage());*/
        $widget = $this->values["widget"]; ?>

        <h1>widget</h1>
        <?php foreach($widget as $key => $value){
          echo "$key : $value <br>
          ";
        }
        ?>