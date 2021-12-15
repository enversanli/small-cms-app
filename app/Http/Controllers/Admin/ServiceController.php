<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /** @var ResponseHelper */
    protected $responseHelper;

    public function __construct(ResponseHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    public function index()
    {
        $services = Service::orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.services.index')->with('services', $services);
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);

        return view('admin.services.detail')->with('service', $service)->with('types', Type::all());
    }

    public function create()
    {
        return view('admin.services.create')->with('types', Type::all());
    }

    public function store(Request $request)
    {
        /** I need to REMEMBER SERVICE TYPE  */
        /** I need to REMEMBER SERVICE REQUIREMENTS  */

        /** Validation */
        $request->validate([
            'title' => 'required|string|min:1|max:255',
            'text' => 'nullable|string',
            'types' => 'required|array',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
            'date_from' => 'nullable|string',
            'date_to' => 'nullable|string',
            'status' => 'nullable|string',
            'rewards' => 'nullable|string|min:1|max:255',
            'rating' => 'nullable|string|min:1|max:255',
            'hardware' => 'nullable|string|min:1|max:255',
            'complexity' => 'nullable|string|min:1|max:255',
        ]);

        try {

            if (isset($request->logo)) {
                $logoName = $request->file('logo')->getClientOriginalName();
                $logoPath = $request->file('logo')->store('public/services');

            }

            if (isset($request->image)) {
                $imageName = $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->store('public/services');
            }


            $service = Service::create([
                'title' => $request->title,
                'text' => $request->text,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
                'status' => $request->status ?? 'Active',
                'logo' => $logoPath ?? null,
                'image' => $imagePath ?? null,
                'rewards' => $request->rewards,
                'rating' => $request->rating,
                'hardware' => $request->hardware,
                'complexity' => $request->complexity
            ]);

            $service->types()->sync($request->types);

            return redirect()->route('service.create')->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.created')])));
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return redirect()->route('service.create')->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }


    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|min:1|max:255',
            'text' => 'nullable|string',
            'types' => 'nullable|array',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
            'date_from' => 'nullable|string',
            'date_to' => 'nullable|string',
            'status' => 'nullable|string',
            'rewards' => 'nullable|string|min:1|max:255',
            'rating' => 'nullable|string|min:1|max:255',
            'hardware' => 'nullable|string|min:1|max:255',
            'complexity' => 'nullable|string|min:1|max:255',
            'lock' => 'nullable|string|min:1|max:255',
        ]);

        try {
            $service = Service::findOrFail($id);

            if (isset($request->logo)) {
                $logoName = $request->file('logo')->getClientOriginalName();
                $logoPath = $request->file('logo')->store('public/services');
                $logoPath = str_replace('public/', '', $logoPath);
                $oldLogo = $service->logo;
            }

            if (isset($request->image)) {
                $imageName = $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->store('public/services');
                $imagePath = str_replace('public/', '', $imagePath);
                $oldImage = $service->image;

            }
            /** Update data */
            $service->update([
                'title' => $request->title,
                'text' => $request->text,
                'logo' => $logoPath ?? $service->logo,
                'image' => $imagePath ?? $service->image,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
                'status' => $request->status ?? $service->status,
                'rewards' => $request->rewards,
                'rating' => $request->rating,
                'hardware' => $request->hardware,
                'complexity' => $request->complexity,
                'lock' => $request->lock
            ]);

            if (isset($request->date_from) && $request->date_from < Carbon::now()->format('Y-m-d')){

            }
            if (isset($request->date_to) && $request->date_to < Carbon::now()->format('Y-m-d')){

            }
            if (isset($request->date_to) && isset($request->date_from) && Carbon::make($request->date_to)->format('Y-m-d') < Carbon::make($request->date_from)->format('Y-m-d')){

            }


            /** Delete Old Storaged Files */
            if (isset($oldImage) && $oldImage != null) {
                Storage::delete($oldImage);
            }

            if (isset($oldLogo) && $oldLogo != null) {
                Storage::delete($oldLogo);
            }

            $service->types()->sync($request->types);

            return redirect()->route('service.show', $service->id)->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.updated')])));
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return redirect()->route('service.show', $service->id)->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));

        }
    }

    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();
            return redirect()->route('services')->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.deleted')])));

        } catch (\Exception $exception) {
            return redirect()->route('services')->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }
    }
}
