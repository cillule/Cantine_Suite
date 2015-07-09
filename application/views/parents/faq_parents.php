<?php $i=0; ?>
<div class="row">
    <div class="panel-group" id="accordion">
        <div class="faqHeader">Foire aux questions</div>
        
        <?php foreach($query->result() as $row): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>">
                        <?php echo $row->question ?> </a>
                </div>
            </div>
           
            <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse">
                <div class="panel-body">
                    <?php echo $row->reponse ?> 
                </div>
            </div>
        </div>
        <?php 
        $i++;
        endforeach; ?>
    </div>
</div>
