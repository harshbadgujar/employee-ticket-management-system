<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Assigned</title>
    <style>
        body {
            font-family: 'Figtree', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
            color: #1f2937;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.025em;
        }
        .content {
            padding: 30px;
        }
        .welcome-text {
            font-size: 16px;
            line-height: 1.6;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .details-card {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .detail-row {
            margin-bottom: 12px;
            font-size: 15px;
        }
        .detail-row:last-child {
            margin-bottom: 0;
        }
        .label {
            font-weight: 600;
            color: #4b5563;
            width: 120px;
            display: inline-block;
        }
        .value {
            color: #111827;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 9999px;
            text-transform: uppercase;
        }
        .badge-high {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .badge-medium {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-low {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-open {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .btn-container {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            background-color: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 24px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 6px;
            display: inline-block;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }
        .footer {
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Ticket Assigned</h1>
        </div>
        <div class="content">
            <p class="welcome-text">Hello {{ $ticket->assignedEmployee->name }},</p>
            <p class="welcome-text">A new support ticket has been assigned to you. Here are the details of the ticket:</p>
            
            <div class="details-card">
                <div class="detail-row">
                    <span class="label">Ticket ID:</span>
                    <span class="value">#{{ $ticket->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Title:</span>
                    <span class="value">{{ $ticket->title }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Priority:</span>
                    <span class="value">
                        <span class="badge badge-{{ strtolower($ticket->priority) }}">
                            {{ $ticket->priority }}
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="label">Status:</span>
                    <span class="value">
                        <span class="badge badge-open">
                            {{ $ticket->status }}
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="label">Created By:</span>
                    <span class="value">{{ $ticket->creator->name }}</span>
                </div>
                <div class="detail-row" style="margin-top: 15px;">
                    <span class="label" style="display: block; margin-bottom: 5px;">Description:</span>
                    <span class="value" style="display: block; line-height: 1.5; color: #374151;">
                        {{ $ticket->description }}
                    </span>
                </div>
            </div>

            <p class="welcome-text">Please review the ticket and update the status as you make progress on resolving the issue.</p>

            <div class="btn-container">
                <a href="{{ url('/tickets/' . $ticket->id) }}" class="btn">View Ticket Details</a>
            </div>
        </div>
        <div class="footer">
            <p>This is an automated notification from the Employee Support Ticket System.</p>
            <p>&copy; {{ date('Y') }} Employee Ticket System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
