<?php

namespace Sesuva\Newsletter\Repositories;

use Sesuva\Newsletter\Models\Subscriber;

class SubscriberRepository
{
    public function create(array $data): Subscriber
    {
        return Subscriber::create($data);
    }

    public function findByEmail(string $email): ?Subscriber
    {
        return Subscriber::byEmail($email)->first();
    }

    public function subscribe(string $email, ?string $name = null): Subscriber
    {
        $subscriber = $this->findByEmail($email) ?? new Subscriber();
        $subscriber->fill([
            'email' => $email,
            'name' => $name ?? $email,
            'is_subscribed' => true,
            'subscribed_at' => now(),
        ])->save();

        return $subscriber;
    }

    public function unsubscribe(string $email): ?Subscriber
    {
        $subscriber = $this->findByEmail($email);
        if ($subscriber) {
            $subscriber->unsubscribe();
        }

        return $subscriber;
    }

    public function verify(string $token): ?Subscriber
    {
        $subscriber = Subscriber::where('verification_token', $token)->first();
        if ($subscriber) {
            $subscriber->verify();
        }

        return $subscriber;
    }

    public function getSubscribed(int $perPage = 100)
    {
        return Subscriber::subscribed()
            ->paginate($perPage);
    }

    public function getAll(int $perPage = 100)
    {
        return Subscriber::paginate($perPage);
    }

    public function count(): int
    {
        return Subscriber::subscribed()->count();
    }

    public function delete(Subscriber $subscriber): bool
    {
        return $subscriber->delete();
    }

    public function deleteByEmail(string $email): bool
    {
        $subscriber = $this->findByEmail($email);

        return $subscriber ? $subscriber->delete() : false;
    }
}
