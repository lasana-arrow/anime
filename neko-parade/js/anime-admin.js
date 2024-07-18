
function addRace()

{	var num=document.getElementById('all_contributers');
	var races_num=Number.parseInt(num.value);
	var prevnum=races_num-1;
	num.value=races_num+1;
	console.log(races_num);
	div2 = document.getElementById('div_contributer_'+prevnum).cloneNode(true);
	div2.id='div_contributer_'+races_num;
	console.log(div2);
	div2.querySelector('#anime_contributer_'+prevnum).name='anime_contributer_'+races_num;
	div2.querySelector('#anime_contributer_'+prevnum).id='anime_contributer_'+races_num;
    div2.querySelector('#anime_role_'+prevnum).name='anime_role_'+races_num;
	div2.querySelector('#anime_role_'+prevnum).id='anime_role_'+races_num;
    div2.querySelector('#delete_button_'+prevnum).setAttribute('onclick', 'JavaScript: deleteRace('+races_num+')');
    div2.querySelector('#delete_button_'+prevnum).id='delete_button_'+races_num;
	console.log(div2);
	document.getElementById('div_contributer_'+prevnum).after(div2);
	
}

function deleteRace(id)
{
	
	// Находим значение кол-во всех участников
	
	var num=document.getElementById('all_contributers');	
	var races_num=Number.parseInt(num.value);
	var delcon=document.getElementById('deleted_contributers');
	var delcon_nums=Number.parseInt(delcon.value);
	if (races_num>1)
		{  // Если оно больше 1 - уменьшаем на 1
	       num.value=races_num-1;	
	    	// Нам нужно запомнить тех контрибьюторов и их роди, которые мы удалили из записи
	    	// Это сколько их
 	       delcon.value=delcon_nums+1;
			// Это сами записи
					 
           // Удаляем узел с номером id
	       var node=document.querySelector('#div_contributer_'+id);	
		   node.parentNode.removeChild(node);	
	       // Находим все элементы <input>, которые мы пометили классом contributer и выдаём им номера по очереди
	       var el=document.querySelectorAll('.contributer');
	       for (var i=0; i<el.length; i++ )
		    {el[i].name='anime_contributer_'+i;}
		   el=document.querySelectorAll('.role');
	       for (var i=0; i<el.length; i++ )
		    {el[i].name='anime_role_'+i;}
				
		}
	else
		{
		   num.value=0;
		   var node=document.querySelector('#first_value_0');
		   node.value=0;
		   node.value.innerHTML='Все участники удалены.';	
		   var node=document.querySelector('#first_role_0');
		   node.value=0;
		   node.value.innerHTML='Все роли удалены.';	
		
		}
	
}