<?php

namespace App\Exports;

use App\Models\Atendidos;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping; 
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents; 
use Maatwebsite\Excel\Events\AfterSheet;   
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PersonaExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithEvents, ShouldAutoSize
{
    protected $fechaInicio;
    protected $fechaFin;
    protected $request;

    public function __construct($fechaInicio, $fechaFin, $request = null)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->request = $request;
    }

    public function collection()
    {
        $query = Atendidos::with(['personas.parroquia.municipio.estado', 'asuntos.patria', 'usuarios'])
            ->orderBy('fecha_atencion', 'desc')
            ->whereBetween('fecha_atencion', [$this->fechaInicio, $this->fechaFin]);

        if ($this->request) {
            $query->filtros($this->request);
        }

        return $query->get();
    }

    /** @var \App\Models\Atendidos $atendido */
    public function map($atendido): array
    {
        $fechaNacimiento = optional($atendido->personas)->fecha_nacimiento;
        $fechaNacimientoFormateada = $fechaNacimiento ? \Carbon\Carbon::parse($fechaNacimiento)->format('d/m/Y') : '';
        
        $fechaAtencion = optional($atendido)->fecha_atencion;
        $fechaAtencionFormateada = $fechaAtencion ? \Carbon\Carbon::parse($fechaAtencion)->format('d/m/Y') : '';
        $asuntoPatria = "";

        foreach ($atendido->asuntos as $asunto) {
            if ($asunto->patria) {
                $asuntoPatria .= $asunto->patria->opciones . ", ";
            }
        }

        return [
            optional($atendido->personas)->cedula, 
            optional($atendido->personas)->nombre, 
            optional($atendido->personas)->sexo == 1 ? 'Masculino' :  'Femenino',
            $fechaNacimientoFormateada, 
            optional($atendido->personas)->correo,
            optional($atendido->personas)->telefono,
            optional($atendido->personas->parroquia->municipio->estado)->estado,
            optional($atendido->personas->parroquia->municipio)->municipio,
            optional($atendido->personas->parroquia)->parroquia,
            optional($atendido->personas)->comuna,
            optional($atendido->personas)->consejo_comunal,
            optional($atendido->usuarios)->name, 
            // // Si 'asuntos' tiene relación con 'patria'
            $asuntoPatria,
            $fechaAtencionFormateada
        ];
    }

    // Encabezados para las columnas
    public function headings(): array
    {
        return [
            'Cédula',
            'Nombre',
            'Sexo',
            'Fecha de Nacimiento',
            'Correo',
            'Teléfono',
            'Estado',
            'Municipio',
            'Parroquia',
            'Comuna',
            'Circuito Comunal',
            'Atendido por',
            'Asunto / Patria',
            'Fecha de Atención',
        ];
    }

    // Agregar el método styles para activar el filtro automático
    public function styles(Worksheet $sheet)
    {
        // Activa el filtro en todo el rango con cabeceras
        $sheet->setAutoFilter('A1:N' . ($sheet->getHighestRow()));
        
        // Poner en negrita la fila de los encabezados
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Obtener la hoja actual
                $sheet = $event->sheet->getDelegate();

                // Crear el objeto para la imagen
                $drawing = new Drawing();
                $drawing->setName('Corpocentro');
                $drawing->setPath(public_path('img/headerpdf.png'));
                $drawing->setCoordinates('A1'); 
                $drawing->setWidth(600); 
                $drawing->setWorksheet($sheet);
            },
        ];
    }
}