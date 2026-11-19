<?php
declare(strict_types=1);
abstract class Student {
    public function __construct(
        protected string $id,
        protected string $name,
        protected float $baseFee
    ) {}
    public function getId(): string {
        return $this->id;
    }
    public function getName(): string {
        return $this->name;
    }
    abstract public function calculateFee(): float;
    public function summary(): string {
        return $this->id . ' - ' . $this->name;
    }
}
class RegularStudent extends Student {
    public function calculateFee(): float {
        return $this->baseFee;
    }
}
class ScholarshipStudent extends Student {
    public function __construct(
        string $id,
        string $name,
        float $baseFee,
        private float $discountPercent
    ) {
        if ($discountPercent < 0 || $discountPercent > 100) {
            throw new InvalidArgumentException('Invalid discount');
        }
        parent::__construct($id, $name, $baseFee);
    }
    public function calculateFee(): float {
        return $this->baseFee * (1 - $this->discountPercent / 100);
    }
    public function summary(): string {
        return parent::summary() . ' [Scholarship]';
    }
}
// CHILD BARU: biaya = biaya dasar + biaya internasional
class InternationalStudent extends Student {
    public function __construct(
        string $id,
        string $name,
        float $baseFee,
        private string $country,
        private float $internationalFee
    ) {
        if ($internationalFee < 0) {
            throw new InvalidArgumentException('Invalid international fee');
        }
        parent::__construct($id, $name, $baseFee);
    }
    public function calculateFee(): float {
        return $this->baseFee + $this->internationalFee;
    }
    public function summary(): string {
        return parent::summary() . ' [International - ' . $this->country . ']';
    }
}
// Repository: tidak menyebut nama class child sama sekali
class StudentRepository {
    /** @var Student[] */
    private array $items = [];
    public function add(Student $student): void {
        $this->items[$student->getId()] = $student;
    }
    public function all(): array {
        return array_values($this->items);
    }
    public function totalFee(): float {
        $total = 0.0;
        foreach ($this->items as $s) {
            $total += $s->calculateFee();
        }
        return $total;
    }
}
// Kode pengujian
$repo = new StudentRepository();
$repo->add(new RegularStudent('M01', 'Alya', 5000000));
$repo->add(new ScholarshipStudent('M02', 'Bima', 5000000, 40));
$repo->add(new InternationalStudent(
    'M03',
    'Chen',
    5000000,
    'China',
    2000000
));
foreach ($repo->all() as $s) {
    printf("%s | Rp%.0f<br>", $s->summary(), $s->calculateFee());
}
printf("Total: Rp%.0f<br>", $repo->totalFee()); 
?>
