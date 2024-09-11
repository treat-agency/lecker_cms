$(document).ready(function () {
	addGlobalListeners(true)

});



function addGlobalListeners(toggle) {
	if (toggle) {
		$('.close_overlay , #signupBG').click(function () {
			$('#signupBG').hide();
			$('#signup_holder').hide();

		});

		$('.repo_item_select').click(function () {

			var repo_item_id = $(this).attr('iid');
			var type = $(this).attr('type');
			var fname = $(this).attr('fname');
			var title = $(this).attr('title');
			saveRepoItem(item_id, repo_item_id, type, fname, title);
		});

		$('#sort_events_date').on('change', function () {
			var category_id = $(this).val();

			if (category_id == 'all') {
				$('.signup_item').show();
			} else {
				$('.signup_item').each(function (i, item) {
					var past = $(this).attr('past');
					if (past == 1) {
						$(this).hide();
					} else {
						$(this).show();
					}

				});
			}
		});


		$('.signup_item').on('click', function () {
			var tour_id = $(this).attr('sid');
			getTourParticipants(tour_id);
		});

		$('.delete').on('click', function () {
			$(this).siblings('.delete_confirm').show();
		});

		$('.d_cancel').on('click', function () {
			$('.delete_confirm').hide();
		});
		
		
		$('.d_confirm').on('click', function () {
			var id = $(this).attr('id');
			var tid = $(this).attr('tid');
			deleteParticipant(id, tid)
		});
		
		
		
		
		
		
		$('.edit').on('click', function () {
			$(this).siblings('.edit_container').show();
		});
		
		$('.e_cancel').on('click', function () {
			$('.edit_container').hide();
		});

		$('.e_confirm').on('click', function () {
			var id = $(this).attr('id');
			var tid = $(this).attr('tid');
			editParticipant(id, tid);
		});

	} else {
		$('.close_overlay').off('click');
		$('.signup_item').off('click');
		$('#sort_events_date').off('change');

	}

}


function getTourParticipants(tour_id) {

	$.ajax({
		url: rootUrl + 'Backend/getParticipants',
		data: {
			tour_id: tour_id
		},
		method: 'POST',
		success: function (data) {
			var ret = $.parseJSON(data);
			if (ret.success) {
				addGlobalListeners(false);
				$('#event_participants_holder').empty();
				$.each(ret.participants, function (i, item) {
					var elem = '<div class="participant_item" pid="' + item.id + '">' +
						'<span class="pn" style="font-weight: bold">' + item.name + '</span> - ' +
						'<span class="pe">' + item.email + '</span> - ' +
						'<span class="pp">' + item.phone + '</span>' +
						'<div class="pa">Erwachsene: <span class="paa">' + item.num_ppl + '</span> // Kinder: <span class="paa">' + item.num_child + '</span></div>' +
						'<div class="pc" style="font-size:14px;">' + item.comment + '</div>' +
						'<div class="delete_edit_container">  <div id="' + item.id + '" class="edit">Edit</div> <div class="delete">Delete </div> ' +

						`<div class="edit_container">
							` + item.name + `
							<form id="form_`+ item.id +`" class="module_form" method="post" style="font-size:16px;">
								<div class="bold" style="margin:10px 0px;font-size:18px;"> </div>
								<input hidden class="module_contact_input" type="number" name="id" value="`+ item.id +`"/>
								<input class="module_contact_input" type="number" name="tour_num_people" value="`+ item.num_ppl +`"/>
								<input class="module_contact_input" type="number" name="tour_num_children" value="`+ item.num_child +`"/>
								<input class="module_contact_input" type="text" name="tour_name" value="`+ item.name +`"/>
								<input class="module_contact_input" type="text" name="tour_email" value="`+ item.email + `"/>
								<input class="module_contact_input" type="text" name="tour_phone" value="`+ item.phone +`"/>
								<textarea class="module_contact_input" name="tour_comment" placeholder="comment">`+ item.comment + `</textarea>									
							
							</form>
							<div class="e_confirm e_btn" tid="`+ tour_id +`" id="`+ item.id +`"> Submit </div>
							<div class="e_cancel d_btn"> Cancel </div> 
						</div>` +

						'<div class="delete_confirm"> Are you sure you want to delete ' + item.name + ' ? <div class="d_confirm d_btn" tid="' + tour_id + '" id="' + item.id + '"> Yes </div> <div class="d_cancel d_btn"> Cancel </div>   </div> </div>' +

						'</div>';
					$('#event_participants_holder').append(elem);
				});


				addGlobalListeners(true);
				$('#event_name').empty().text(ret.name);
				$('#event_date').empty().text(ret.date);
				$('#signupBG').show();
				$('#signup_holder').show();

			} else {

			}
		}
	});
}

function deleteParticipant(id, tid) {

	$.ajax({
		url: rootUrl + 'Backend/deleteParticipant',
		data: {
			participant: id
		},
		method: 'POST',
		success: function (data) {
			var ret = $.parseJSON(data);
			if (ret.success) {} else {}
		}
	});

	getTourParticipants(tid);
}


function editParticipant(id, tid){

	$.ajax({
		url: rootUrl + 'Backend/editParticipant',
		data:  $('#form_' + id).serialize(),
		
		method: 'POST',
		success: function (data) {
			var ret = $.parseJSON(data);
			if (ret.success) {

			} else {

			}
		}
	});

	getTourParticipants(tid);
}

