echo "Defining pin state"
gpio mode 3 out
gpio mode 2 in
echo "Setting up CAN interface"
sudo ip link set can0 up type can bitrate 181818 loopback off
echo "Starting Laravel server"
php artisan serve --host 0.0.0.0 --port=8000
