<?php

$allOrders=OrdersFromStore::model()->findAll();
if($allOrders)
{
    echo "<table>";
    foreach($allOrders as $index=>$order)
    {
        echo "<tr><td>";
        $form = $this->beginWidget('CActiveForm', array(
            'id'=>'user-form',
            'enableAjaxValidation'=>false,
            'action'=>Yum::module('store')->ordersapprove,
            'enableClientValidation'=>true,
        ));

        $user_name="";
        if($order->user_id>0)
        {
            $user_store=YumUser::model()->findByPk($order->user_id);
            if($user_store)
                $user_name=$user_store->username;
        }
        $store_item_name_name="";
        if($order->store_item_id>0)
        {
            $store_item=Store::model()->findByPk($order->store_item_id);
            if($store_item)
                $store_item_name_name=$store_item->title;
        }
        echo "<div>User: ".$user_name."</div>";
        echo "<div>Store item: ".$store_item_name_name."</div>";
        echo $form->hiddenField($order,"id", array("value" => $order->id));
        echo CHtml::submitButton(Yum::t('Approve'),array('name' => 'approvesubmit'));
        echo CHtml::submitButton(Yum::t('Reject'),array('name' => 'rejectsubmit'));
        echo "</td></tr>";
        $this->endWidget();
    }
    echo "</table>";

}
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('a.store-delete').on('click',function()
        {
            return confirm("Are you sure?")?true:false;
        })
    })
</script>
