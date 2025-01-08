<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;
use Illuminate\Support\Str;

class CharacterController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'name'          => 'bail|required|max:255',
            'chronicle'     => 'bail|required|max:255',
            'level'         => 'bail|required|integer|min:1',
            'xp'            => 'bail|required|integer|min:0',
            'intelligence'  => 'bail|required|integer|min:0|max:50',
            'dexterity'     => 'bail|required|integer|min:0|max:50',
            'charisma'      => 'bail|required|integer|min:0|max:50',
            'strength'      => 'bail|required|integer|min:0|max:50',
            'wisdom'        => 'bail|required|integer|min:0|max:50',
            'constitution'  => 'bail|required|integer|min:0|max:50'
        ]);

        $character = Character::create([
            'user_id' => auth()->id(),
            'unique_id' => Str::uuid(),
            ...$validated
        ]);

        return response()->json([
            'message' => 'Character created sucessfuly',
            'character' => $character
        ], 201);
    }

    public function show($uniqueId) {
        try {
            $character = Character::where('unique_id', $uniqueId)->firstOrFail();

            if ($character->user_id !== auth()->id()) {
                return response()->json([
                    'message'   => 'Unathorized acess'
                ], 403);
            }
            return response()->json($character);
        } catch (\Exception $e) {
            return response()->json([
                'message'   => 'Character not found'
            ], 404);

        }
    }

    public function update(Request $request, $uniqueId) {
        try {
            $character = Character::where('unique_id', $uniqueId)->firstOrFail();

            if ($character->user_id !== auth()->id()) {
                return response()->json([
                    'message'   => 'Unathorized acess'
                ], 403);
            }
            $validated = $request->validate([
                'name'          => 'sometimes|max:255',
                'chronicle'     => 'sometimes|max:255',
                'level'         => 'sometimes|integer|min:1',
                'xp'            => 'sometimes|integer|min:0',
                'intelligence'  => 'sometimes|integer|max:50',
                'dexterity'     => 'sometimes|integer|max:50',
                'charisma'      => 'sometimes|integer|max:50',
                'strength'      => 'sometimes|integer|max:50',
                'wisdom'        => 'sometimes|integer|max:50',
                'constitution'  => 'sometimes|integer|max:50'
            ]);

            $character->update($validated);
            return response()->json([
                'character' => $character,
                'message'   => 'Character updated sucessfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message'   => 'Character not found'
            ], 404);
        }
    }
    public function destroy($uniqueId) {
        try {
            $character = Character::where('unique_id', $uniqueId)->firstOrFail();

            if ($character->user_id !== auth()->id()) {
                return response()->json([
                    'message'   => 'Unathorized Acess'
                ], 403);
            }
            $character->delete();

            return response()->json([
                'message'   => 'Character deleted sucesfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message'   => 'Character not found'
            ], 404);
        }
    }

    public function index() {
        $character = Character::where('user_id', auth()->id())->get();
        return response()->json($characters);
    }
}
