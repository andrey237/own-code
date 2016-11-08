<?php

class BookingRoomsController extends BookingController
{
  // protected $title = 'Номера';
  private $model;

	public function defaultAction()
	{
    $hotel_id = 1;
    $this->model = new BookingRoomsModel();

    $this->data['hotel'] = $this->model->getHotelByID($hotel_id);

    $this->title = $this->data['hotel']['title'] . '. ' . $this->data['hotel']['stars'] . ' звёзд. Номера';

    $this->data['items'] = $this->model->getItems($hotel_id);

    if (User::isAdmin())
    {
      $this->data['types'] = $this->model->getTypes($hotel_id);
    }
	}

}

// SELECT rs_booking_hotels.title, rs_booking_rooms.number, rs_booking_room_types.title, rs_booking_room_types.description, rs_booking_room_types.max_places
// FROM rs_booking_rooms
// JOIN rs_booking_room_types ON rs_booking_rooms.type_id = rs_booking_room_types.id
// JOIN rs_booking_hotels ON rs_booking_rooms.hotel_id = rs_booking_hotels.id