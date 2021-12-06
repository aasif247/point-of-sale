<?php

namespace App\Services\Business;

use App\BusinessObjects\Business;
use App\Repository\Business\IBusinessRepository;
use Exception;
use Illuminate\Support\Str;

class BusinessService implements IBusinessService {

    private $businessRepository;

    public function __construct(IBusinessRepository $businessRepository) {
        $this->businessRepository = $businessRepository;
    }

    public function createBusiness($businessName, $ownerId) {
        $existingName = $this->businessRepository
            ->where('name', $businessName)
            ->first();

        if ($existingName != null ){
            throw new Exception(["error" => 'Business Name Already Taken'], 500);
        }
        else{
            return $this->businessRepository->create([
                'name' => $businessName,
                'user_id' => $ownerId,
                'slug' => Str::slug($businessName),
            ]);
        }
    }

    public function getBusiness($id) {
        return $this->businessRepository->getById($id);
    }

    public function getOwnedBusiness($customerId)
    {
        $business = $this->businessRepository->where('user_id', $customerId)
            ->first();

        if($business != null)
        {
            $businessItem = new Business();
            $businessItem->id = $business->id;
            $businessItem->name = $business->name;
            $businessItem->address = $business->address;
            $businessItem->phone = $business->phone;
            $businessItem->email = $business->email;
            $businessItem->website = $business->website;
            $businessItem->owner = null; // TODO: Need to set owner object here

            return $businessItem;
        }

        return null;
    }

    public function updateBusiness($id, Business $business) {
        return $this->businessRepository->updateById($id,[
            'name' => $business->name,
            'address' => $business->address,
            'phone' => $business->phone,
            'email' => $business->email,
            'website' => $business->website,
        ]);
    }

    public function deleteBusiness($id) {
       $this->businessRepository->deleteById($id);
    }

    public function getAllBusinesses() {
        return $this->businessRepository->getPaginated();
    }

    public function archiveBusiness($id) {
        $business = $this->businessRepository->find($id);
        $business->status = 'archived';
        $business->save();
    }

    public function unarchiveBusiness($id) {
        $business = $this->businessRepository->find($id);
        $business->status = 'pending';
        $business->save();
    }

    public function searchBusiness($search_text) {
        return $this->businessRepository
            ->where('name','LIKE','%'.$search_text.'%')
            ->orWhere('address','LIKE','%'.$search_text.'%')
            ->orWhere('website','LIKE','%'.$search_text.'%')
            ->paginate(2);
    }
}
