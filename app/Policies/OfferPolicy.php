<?php

namespace App\Policies;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfferPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewMy(User $user): bool
    {
        return $user->isOfferMaker();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Offer $offer
     * @return bool
     */
    public function view(User $user, Offer $offer): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->isOfferMaker();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Offer $offer
     * @return bool
     */
    public function update(User $user, Offer $offer): bool
    {
        return $user->isOfferMaker() && $user->id === $offer->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Offer $offer
     * @return bool
     */
    public function delete(User $user, Offer $offer): bool
    {
        return $user->isOfferMaker() && $user->id === $offer->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Offer $offer
     * @return bool
     */
    public function restore(User $user, Offer $offer): bool
    {
        return $user->isOfferMaker() && $user->id === $offer->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Offer $offer
     * @return bool
     */
    public function forceDelete(User $user, Offer $offer): bool
    {
        return $user->isOfferMaker() && $user->id === $offer->user_id;
    }
}
