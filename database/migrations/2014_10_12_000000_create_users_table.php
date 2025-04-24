<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

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
        $this->table = (new User())->getTable();
    }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique(); //adding email as unique identifier for users
                $table->tinyInteger('age')->default(0);
                $table->biginteger('points')->default(0);
                $table->string('address')->nullable();
                $table->softDeletes();
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
