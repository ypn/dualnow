<?php 
	return [
	'lanes'=>[
		"top" => (object)array('des'=>'Đường trên','offset'=>0),
        "jung"=> (object)array('des'=>"Đi rừng",'offset'=>3),
        "mid" => (object)array('des'=>"Đường giữa",'offset'=>2),
        "ad"  => (object)array('des'=>"Xạ thủ",'offset'=>5),
        "sp"  => (object)array('des'=>"Hỗ trợ",'offset'=>1),
        "all" => (object)array('des'=>"Moị vị trí",'offset'=>4)
	],

	'ranks'=>array('Chưa cập nhật',
                'Đồng I','Đồng II','Đồng III','Đồng IV','Đồng V',
                'Bạc I','Bạc II','Bạc III','Bạc IV','Bạc V',
                'Vàng I','Vàng II','Vàng III','Vàng IV','Vàng V',
                'Bạch kim I','Bạch kim II','Bạch kim III','Bạch kim IV','Bạch kim V',
                'Kim cương I','Kim cương II','Kim cương III','Kim cương IV','Kim cương V',
                'Cao thủ I','Thách đấu đoàn I','Chưa có hạng'
                ),

	'group_ranks' => array(		
			'Đồng đoàn'=>array(1,2,3,4,5),
			'Bạc đoàn'=>array(6,7,8,9,10),
			'Vàng đoàn'=>array(11,12,13,14,15),
			'Bạch kim đoàn'=>array(16,17,18,19,20),
			'Kim cương đoàn'=>array(21,22,23,24,25),
			'Cao thủ - Thách đấu'=>array(26,27)
			),
	'styles_of_player'=>array('Biết lắng nghe','Hổ háo','Chuyên đẩy đường','Kiểm soát bản đồ','Mở đầu giao tranh','Tùy cơ ứng biến','Bảo kê','Sát thủ','Gánh đội')
	];


 ?>
