# Invoice Hub

A comprehensive Laravel application for managing customers and invoices efficiently using PHP and MySQL.

## 📋 Features

Invoice Hub is a full-featured invoice management system that allows you to:

- **Customer Management**
  - Create and maintain a customer database
  - Store contact information, addresses, and notes
  - View customer history and associated invoices

- **Invoice Management**
  - Create professional invoices with dynamic line items
  - Track invoice status (draft, sent, paid, overdue, cancelled)
  - Calculate subtotals, taxes, and discounts automatically
  - Print-ready invoice display

- **Dashboard**
  - View key metrics at a glance
  - See recent customer and invoice activity
  - Track outstanding payments

## 🚀 Installation

Follow these steps to get Invoice Hub up and running on your local machine:

1. **Clone the repository**
   ```
   git clone https://github.com/yourusername/invoice-hub.git
   cd invoice-hub
   ```

2. **Install PHP dependencies**
   ```
   composer install
   ```

3. **Install and compile frontend assets**
   ```
   npm install
   npm run dev
   ```

4. **Set up environment variables**
   ```
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your database**
   
   Edit the `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=invoice_hub
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run migrations and seeders**
   ```
   php artisan migrate --seed
   ```

7. **Start the development server**
   ```
   php artisan serve
   ```

8. **Access the application**
   
   Visit `http://localhost:8000` in your web browser

## 🏗️ Project Structure

The application follows standard Laravel project structure:

- `app/` - Contains the core code of the application
  - `Http/Controllers/` - Controllers for handling requests
  - `Models/` - Eloquent models for database interaction
  - `Http/Requests/` - Form validation request classes
- `database/` - Contains migrations and seeders
- `resources/views/` - Blade templates for the frontend
- `routes/` - Route definitions

## 🧪 Testing

Run the tests with:

```
php artisan test
```

## 🔄 Future Enhancements

Potential improvements for future versions:

- PDF invoice generation
- Email notifications for invoices
- Integration with payment gateways
- User roles and permissions
- Advanced reporting and analytics

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.
