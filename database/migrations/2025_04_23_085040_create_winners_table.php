<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Winner;

return new class extends Migration
{
    /**
     * The name of the table.
     *
     * @var string
     */
    protected $table;
    /**
     * Create a new migration instance.
     *
     * @param  string  $table
     * @return void
     */
    public function __construct()
    {
        $this->table = (new Winner())->getTable();
    }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->on('users')->constrained()->cascadeOnDelete();
                $table->bigInteger('winner_points')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
