<?php
// �����ϥޥ�ե�����
// Sweatjack ���ʥ����������饹
// charset euc-jp

	require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/conndb.php';

	/**
	*	getTableList		�ơ��֥�ꥹ�Ȥ��֤�
	*	getItemPrice		���ʤ�ñ�����֤�
	*/
	class Catalog extends Conndb{

		public function __construct(){
		}
		
		
		/**
		*	�ǡ����١����Υơ��֥�ꥹ�Ȥ��֤�
		*	@mode			�ǡ����١����Υơ��֥�̾
		*	@item_id		�����ƥ�ID
		*	@itemcolor_code	�����ƥ�Υ��顼������
		*	@part			1:�ѡ�����  2:�ѥ��  null(default):����
		*
		*	@return			�ơ��֥�Υ쥳����
		*/
		public function getTablelist($mode, $item_id=NULL, $itemcolor_code=NULL, $part=NULL){
			$rs = parent::sjTablelist($mode, $item_id, $itemcolor_code, $part);
			return $rs;
		}


		/**
		*		�������ʤ�ñ�����֤��ʥ�����ID��0�λ��Ϻ�����ʤ��֤���
		*		@item_id		�����ƥ��ID
		*		@size_id		��������ID
		*		@points			�ץ��Ȥ�̵ͭ��1..���� or 0..�ʤ���
		*		@isWhite		���..1 or ����ʳ�..0(default)
		*		@mode			�����ϥ޲��ʤΤ�..0(default) or �᡼�������ʤ��֤�..1
		*/
		public function getItemPrice($item_id, $size_id, $points, $isWhite=0, $mode=0){
			$rs = parent::sjItemPrice($item_id, $size_id, $points, $isWhite, $mode);
			return $rs;
		}


		/**
		*		�������ʤξ�����֤��ʲ��ʤϺ�������ӤΤߡ�
		*		���ʤ�������ʤ˷׻��Ѥ�
		*		@part			1:�ѡ�����  2:�ѥ��  null(default):����
		*		@keyname		�֤��ͤ�����Υ�������ꡢdefault ['item_id']
		*/
		public function getItemInfo($part=null, $keyname="item_id"){
			$rs = parent::sjItemInfo($part, $keyname);
			return $rs;
		}

	}
