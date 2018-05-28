<?php
// В качестве примера можно привести калькулятор («создатель»),
// у которого любая последняя выполненная операция сохраняется в памяти («хранитель»),
// чтобы вы могли снова вызвать её с помощью каких-то кнопок («опекун»).

// Шаблон «Хранитель» фиксирует и хранит текущее состояние объекта, чтобы оно легко восстанавливалось.

// Текстовый редактор время от времени сохраняет своё состояние, чтобы можно было восстановить текст в каком-то прошлом виде.

class EditorMemento
{
    protected $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
}

class Editor
{
    protected $content = '';

    public function type(string $words)
    {
        $this->content = $this->content . ' ' . $words;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function save()
    {
        return new EditorMemento($this->content);
    }

    public function restore(EditorMemento $memento)
    {
        $this->content = $memento->getContent();
    }
}


$editor = new Editor();

// Пишем что-нибудь
$editor->type('This is the first sentence.');
$editor->type('This is second.');

// Сохранение состояния в: This is the first sentence. This is second.
$saved = $editor->save();

// Пишем ещё
$editor->type('And this is third.');

// Output: Содержимое до сохранения
echo $editor->getContent(); // This is the first sentence. This is second. And this is third.

// Восстанавливаем последнее сохранённое состояние
$editor->restore($saved);

$editor->getContent(); // This is the first sentence. This is second.