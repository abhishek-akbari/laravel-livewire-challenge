<?php

use Livewire\Volt\Component;
use App\Models\Task;

new class extends Component {
    public string $title = '';

    public function addTask(): void
    {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
        ]);

        Task::create([
            'title' => $validated['title'],
            'completed' => false,
        ]);

        $this->title = '';
    }

    public function toggle($id): void
    {
        $task = Task::findOrFail($id);
        $task->completed = !$task->completed;
        $task->save();
    }

    public function with(): array
    {
        return [
            'tasks' => Task::latest()->get(),
        ];
    }
}; ?>

<div>
    <style>
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 2.5rem;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: var(--shadow-primary);
            animation: cardEntrance 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            margin-bottom: 2.2rem;
            text-align: center;
        }

        .header h1 {
            font-size: 2.4rem;
            font-weight: 700;
            letter-spacing: -0.05em;
            background: linear-gradient(135deg, #ffffff 0%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.4rem;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .input-container {
            display: flex;
            gap: 0.75rem;
        }

        .input-field {
            flex: 1;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 1rem 1.25rem;
            font-size: 0.95rem;
            border-radius: 14px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: inherit;
        }

        .input-field::placeholder {
            color: rgba(148, 163, 184, 0.5);
        }

        .input-field:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px var(--accent-glow);
            background: rgba(15, 23, 42, 0.8);
        }

        .input-field.error-input {
            border-color: var(--danger-color);
        }

        .btn-primary {
            background: var(--accent-color);
            color: #ffffff;
            border: none;
            padding: 1rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: inherit;
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .error-text {
            color: var(--danger-color);
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: block;
            font-weight: 500;
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .task-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            max-height: 400px;
            overflow-y: auto;
            padding-right: 2px;
        }

        .task-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.1rem 1.25rem;
            background: rgba(15, 23, 42, 0.35);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .task-item:hover {
            background: rgba(15, 23, 42, 0.55);
            border-color: rgba(255, 255, 255, 0.12);
            transform: translateX(2px);
        }

        .task-item.completed {
            background: rgba(15, 23, 42, 0.18);
            border-color: rgba(255, 255, 255, 0.03);
        }

        .task-content {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-custom {
            width: 22px;
            height: 22px;
            border-radius: 7px;
            border: 2px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            background: transparent;
            flex-shrink: 0;
        }

        .task-item:hover .checkbox-custom {
            border-color: rgba(255, 255, 255, 0.3);
        }

        .task-item.completed .checkbox-custom {
            background: var(--success-color);
            border-color: var(--success-color);
        }

        .checkbox-icon {
            width: 14px;
            height: 14px;
            color: #ffffff;
            display: none;
        }

        .task-item.completed .checkbox-icon {
            display: block;
        }

        .task-title {
            font-size: 0.95rem;
            color: var(--text-primary);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            line-height: 1.4;
        }

        .task-item.completed .task-title {
            color: var(--text-secondary);
            text-decoration: line-through;
            opacity: 0.65;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-secondary);
            font-size: 0.95rem;
            border: 1px dashed rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            background: rgba(15, 23, 42, 0.1);
        }

        .empty-icon {
            width: 32px;
            height: 32px;
            color: rgba(148, 163, 184, 0.35);
            margin: 0 auto 0.75rem auto;
            display: block;
        }
    </style>

    <div class="card">
        <div class="header">
            <h1>Task Flow</h1>
            <p>Manage your daily activities simply &amp; beautifully</p>
        </div>

        <form wire:submit.prevent="addTask" class="form-group" novalidate>
            <div class="input-container">
                <input 
                    type="text" 
                    wire:model="title" 
                    placeholder="Create a new task..." 
                    class="input-field @error('title') error-input @enderror"
                    id="task-title-input"
                    autocomplete="off"
                    required
                >
                <button type="submit" class="btn-primary" id="add-task-btn">
                    Add Task
                </button>
            </div>
            @error('title')
                <span class="error-text" id="title-error">{{ $message }}</span>
            @enderror
        </form>

        <ul class="task-list">
            @forelse ($tasks as $task)
                <li class="task-item {{ $task->completed ? 'completed' : '' }}" id="task-{{ $task->id }}">
                    <div class="task-content" wire:click="toggle({{ $task->id }})" id="toggle-task-{{ $task->id }}">
                        <div class="checkbox-custom">
                            <svg class="checkbox-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="task-title">{{ $task->title }}</span>
                    </div>
                </li>
            @empty
                <li class="empty-state">
                    <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-.621-.504-1.125-1.125-1.125H9.75M8.25 21h8.25c1.243 0 2.25-1.007 2.25-2.25V6.75C18.75 5.507 17.743 4.5 16.5 4.5H7.5C6.257 4.5 5.25 5.507 5.25 6.75v12c0 1.243 1.007 2.25 2.25 2.25z" />
                    </svg>
                    <p>No tasks yet. Create one to get started!</p>
                </li>
            @endforelse
        </ul>
    </div>
</div>
