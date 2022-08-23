<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHotelMappingRequest;
use App\Http\Requests\UpdateHotelMappingRequest;
use App\Models\Hotel;
use App\Models\HotelMapping;
use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;
use function GuzzleHttp\Promise\all;

class HotelMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotelMapping_ids = HotelMapping::select('hotel_id')->get()->pluck('hotel_id')->toArray();
        $hotels = Hotel::whereIN('hotel_id',$hotelMapping_ids)->get();
        return Inertia::render('HotelMapping/index', [
            'hotels' => $hotels,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hotelMapping_ids = HotelMapping::select('hotel_id')->get()->pluck('hotel_id')->toArray();
        $hotels = Hotel::whereNotIn('hotel_id',$hotelMapping_ids)->OrderBy('name')->get();

        return Inertia::render('HotelMapping/create', [
            'hotels' =>  $hotels,
            'rooms' => Room::all(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHotelMappingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHotelMappingRequest $request)
    {

        $data = $request->validated();

        collect($data['rooms'])->each(function ($room){
            $hotelMapping =  new HotelMapping() ;
            $hotelMapping->categorie_id = $room['categorie_id'];
            $hotelMapping->hotel_id = $room['hotel_id'];
            $hotelMapping->names = $room['names'];
            $hotelMapping->categorie_name = $room['name'];
            $hotelMapping->save();
        });

        return redirect('/hotel-mapping');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HotelMapping  $hotelMapping
     * @return \Illuminate\Http\Response
     */
    public function show(HotelMapping $hotelMapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HotelMapping  $hotelMapping
     * @return \Illuminate\Http\Response
     */
    public function edit(HotelMapping $hotelMapping)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHotelMappingRequest  $request
     * @param  \App\Models\HotelMapping  $hotelMapping
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHotelMappingRequest $request, HotelMapping $hotelMapping)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HotelMapping  $hotelMapping
     * @return \Illuminate\Http\Response
     */
    public function destroy(HotelMapping $hotelMapping)
    {
        //
    }

    public function editMapping(Hotel $hotel)
    {
        return Inertia::render('HotelMapping/edite', [
            'hotel_mapping' => HotelMapping::where('hotel_id',$hotel->hotel_id)->get(),
        ]);
    }

    public function updateMapping(UpdateHotelMappingRequest $request)
    {
        $data = $request->validated();

        HotelMapping::where('hotel_id',$data['rooms'][0]['hotel_id'])->delete();

        collect($data['rooms'])->each(function ($room){
            $hotelMapping =  new HotelMapping() ;
            $hotelMapping->categorie_id = $room['categorie_id'];
            $hotelMapping->hotel_id = $room['hotel_id'];
            $hotelMapping->names = $room['names'];
            $hotelMapping->categorie_name = $room['categorie_name'];
            $hotelMapping->save();
        });

        return redirect('/hotel-mapping');

    }
    public function destroyMapping(Request $request)
    {
        HotelMapping::where('hotel_id',$request->hotel_id)->delete();
        return redirect('/hotel-mapping');

    }
}
