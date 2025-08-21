<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ShippingAddress;
use App\Http\Requests\ShippingAddressRequest;

class ShippingAddressController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $shippingAddresses = $user->shippingAddresses;

        return view('shipping_addresses.index', compact('shippingAddresses'));
    }

    public function store(ShippingAddressRequest $request)
    {
        $user = Auth::user();

        ShippingAddress::create([
            'user_id' => $user->id,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'recipient_name' => $request->recipient_name,
        ]);

        return redirect()->route('shipping_addresses.index')->with('success', '配送先を登録しました。');
    }

    public function edit($id)
    {
        $shippingAddress = ShippingAddress::findOrFail($id);
        return view('shipping_addresses.edit', compact('shippingAddress'));
    }

    public function update(ShippingAddressRequest $request, $id)
    {
        $address = ShippingAddress::where('user_id', Auth::id())->findOrFail($id);
        $address->update($request->only(['postal_code', 'address', 'recipient_name']));

        return redirect()->route('shipping_addresses.index')->with('success', '配送先を更新しました。');
    }

    public function destroy($id)
    {
        $address = ShippingAddress::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();

        return redirect()->route('shipping_addresses.index')->with('success', '配送先を削除しました。');
    }
}
