import React from 'react';
import { BrowserRouter, Route, Routes, Navigate } from 'react-router-dom';
import Login from './pages/Login';
import Dashboard from './pages/Dashboard';
import OrderSummary from './pages/OrderSummary';
import InventoryControl from './pages/InventoryControl';
import PaymentReport from './pages/PaymentReport';

const Router = () => {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/react-login" element={<Login />} />
                <Route path="/dashboard" element={<Dashboard />} />
                <Route path="/order-summary" element={<OrderSummary />} />
                <Route path="/inventory-control" element={<InventoryControl />} />
                <Route path="/payment-report" element={<PaymentReport />} />
                <Route path="/" element={<Navigate to="/login" replace />} />
            </Routes>
        </BrowserRouter>
    );
};

export default Router;