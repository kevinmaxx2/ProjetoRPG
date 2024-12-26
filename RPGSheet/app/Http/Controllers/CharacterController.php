<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;

class CharacterController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'user_id'       => auth()->id(),
            'name'          => 'bail|required|max:255',
            'chronicle'     => 'bail|required|max:255',
            'intelligence'  => 'bail|required|integer|min:0|max:50',
            'dexterity'     => 'bail|required|integer|min:0|max:50',
            'charisma'      => 'bail|required|integer|min:0|max:50',
            'strength'      => 'bail|required|integer|min:0|max:50',
            'wisdom'        => 'bail|required|integer|min:0|max:50',
            'constitution'  => 'bail|required|integer|min:0|max:50'
        ]);

        $character = Character::create([
            'name'  => $validated['name'],
            'chronicle'  => $validated['chronicle'],
            'intelligence'  => $validated['intelligence'],
            'dexterity'  => $validated['dexterity'],
            'charisma'  => $validated['charisma'],
            'strength'  => $validated['strength'],
            'wisdom'  => $validated['wisdom'],
            'constitution'  => $validated['constitution'],
        ]);

        return response()->json([
            'message' => 'Character created sucessfuly',
            ''
        ], 201);
    }

    public function show($id) {
        try {
            $character = Character::findOrFail($id);
            return response()->json($character);
        } catch (\Exception $e) {
            return response()->json([
                'message'   => 'Character not found'
            ], 404);

        }
    }

    public function update(Request $request, $id) {
        try {
            $character = Character::findOrFail($id);

            $validated = $request->validate([
                'name'          => 'sometimes|max:255',
                'chronicle'     => 'sometimes|max:255',
                'intelligence'  => 'sometimes|max:50',
                'dexterity'     => 'sometimes|max:50',
                'charisma'      => 'sometimes|max:50',
                'strength'      => 'sometimes|max:50',
                'wisdom'        => 'sometimes|max:50',
                'constitution'  => 'sometimes|max:50'
            ]);

            $character->save();
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
    public function destroy($id) {
        try {
            $character = Character::findOrFail($id);
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
}
