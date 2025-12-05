# Instrucciones para Agentes de IA - Sistema Contable Presupuestario

## Arquitectura General

Este es un **sistema de gestión contable y presupuestaria** construido con **CodeIgniter 3** (MVC clásico). El sistema gestiona presupuestos institucionales, ejecución presupuestaria, obligaciones, pagos y asientos contables.

### Estructura de Carpetas Clave
- `application/controllers/` - Controladores organizados por módulos (patrimonio, obligaciones, registro, etc.)
- `application/controllers/patrimonio/` - **Módulo de Patrimonio**: Contiene la gestión de Comprobantes de Gasto (punto inicial del flujo presupuestario)
- `application/controllers/obligaciones/` - Procesos de obligación de gastos (segunda etapa del flujo)
- `application/models/` - Modelos con sufijo `_model` (ej: `EjecucionP_model.php`)
- `application/views/admin/` - Vistas organizadas por módulos
- `application/middlewares/` - Middleware personalizado para autenticación (ver `SesionMiddleware.php`)
- `application/core/MY_Controller.php` - Controlador base con sistema de middleware

## Modelo de Datos Presupuestario (CRÍTICO)

### Flujo de Datos Principal
```
Presupuesto Anual (presupuestos)
  ↓
Plan Financiero Mensual (presupuesto_mensual)
  ↓
Comprobante de Gasto (Patrimonio) → Obligación → Pago
  ↓
Ejecución Mensual (ejecucion_mensual)
  ↓
Reportes Contables (Balance General, Libro Mayor, Sumas y Saldos)
```

**Nota importante:** Los presupuestos solo funcionan dentro del mes actual del servidor. No existe cierre manual de mes; la fecha del servidor determina el mes presupuestario activo.

### Tablas Centrales
- **`presupuestos`**: Presupuesto anual con dimensiones financieras (OF, FF, Programa)
- **`presupuesto_mensual`**: Distribución mensual del presupuesto (`mes` siempre es `Y-m-01 00:00:00`)
- **`ejecucion_mensual`**: Acumulador de montos obligados y pagados por mes
- **`num_asi` / `num_asi_deta`**: Asientos contables con detalle (Debe/Haber)
- **`cuentacontable`**: Plan de cuentas con código jerárquico

### Dimensiones Financieras (Siempre juntas)
Para identificar UN presupuesto único se necesitan 4 campos:
1. `Idcuentacontable` (Cuenta contable)
2. `origen_de_financiamiento_id_of`
3. `fuente_de_financiamiento_id_ff`
4. `programa_id_pro`

**NUNCA** buscar presupuesto solo por cuenta contable, siempre incluir las 4 dimensiones.

## Patrones de Código Específicos

### 1. Autenticación con Middleware
```php
class Mi_Controlador extends MY_Controller {
    protected function middleware() {
        return ['sesion']; // Aplica SesionMiddleware
    }
}
```

### 2. Cálculo de Saldo Presupuestario Mensual
**SIEMPRE usar `EjecucionP_model->calcular_saldo_presupuestario($id_presupuesto)`**

Este método calcula:
- Saldo disponible = Presupuesto mensual - Obligado
- Saldo por pagar = Obligado - Pagado
- Filtra automáticamente por mes actual (`date('Y-m-01 00:00:00')`)

**Flujo de validación:**
- `Comprobante_Gasto`: Solo VALIDAR saldo (no ejecutar)
- `Diario_obligaciones->store()`: EJECUTAR `actualizarEjecucion($numero)` para actualizar `ejecucion_mensual`
- NO duplicar ejecución en ambos lugares

### 3. AJAX con CodeIgniter
```php
// Controlador
public function verificar_saldo() {
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'success', 'data' => $data]));
}
```

### 4. Uso de Query Builder (NO usar consultas raw)
```php
$this->db->select('campo1, campo2');
$this->db->from('tabla');
$this->db->where('id_presupuesto', $id);
$this->db->where('mes', $fecha_mes_actual);
$query = $this->db->get();
```

### 5. Sesiones y Usuario Actual
```php
$nombre = $this->session->userdata('Nombre_usuario');
$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
```

## Convenciones del Proyecto

### Nomenclatura
- Controladores: PascalCase sin sufijo (ej: `Diario_obligaciones`)
- Modelos: PascalCase + `_model` (ej: `EjecucionP_model`)
- Tablas: snake_case (ej: `presupuesto_mensual`)
- Columnas: PascalCase o snake_case (mixto - respetar existente)

### Vistas
- Ubicación: `application/views/admin/{modulo}/archivo.php`
- Usar Bootstrap 5 para estilos
- SweetAlert2 para alertas: `Swal.fire({...})`
- DataTables para tablas interactivas

### Frontend
- **jQuery** es la librería principal (NO usar vanilla JS moderno en código existente)
- AJAX con `$.ajax()` para comunicación con backend
- Modales con Bootstrap 5: `data-bs-toggle="modal"`

## Comandos de Desarrollo

### Configuración Local (Laragon)
- URL base: `http://localhost/practica`
- Base de datos: Configurar en `application/config/database.php`
- PHP 7.4+ requerido

### Logs
- Ubicación: `application/logs/log-{fecha}.php`
- Usar: `log_message('error', 'Mensaje aquí');`

## Casos de Uso Críticos

### Crear Nueva Obligación
1. Validar saldo en `Comprobante_Gasto` (solo lectura)
2. Guardar en `comprobantegasto` (no afecta ejecución)
3. En `Diario_obligaciones->store()`:
   - Insertar en `num_asi` y `num_asi_deta`
   - Ejecutar `EjecucionP_model->actualizarEjecucion($numero)`
   - Actualizar `ejecucion_mensual.obligado`

### Mostrar Saldo en Modales
1. Obtener `id_presupuesto` con las 4 dimensiones financieras
2. Llamar a `verificar_saldo` (reutilizable)
3. Mostrar alerta temporal (auto-cerrar en 10-15 seg)

## Anti-Patrones a Evitar

❌ Buscar presupuesto solo por cuenta contable (ambiguo)  
❌ Duplicar cálculo de saldo (usar `calcular_saldo_presupuestario`)  
❌ Ejecutar presupuesto en múltiples lugares (solo en `actualizarEjecucion`)  
❌ Usar `$query->row()` cuando puede haber múltiples resultados  
❌ Olvidar validar saldo antes de guardar comprobantes  

## Referencias Clave

- `EjecucionP_model.php`: Lógica de cálculo de saldos y ejecución
- `Diario_obligaciones.php`: Flujo completo de obligaciones
- `Comprobante_Gasto.php`: Validación de saldo pre-registro
- `MY_Controller.php`: Sistema de middleware
- `Tablas Relevantes para el cálculo del sa.txt`: Esquema de BD documentado
