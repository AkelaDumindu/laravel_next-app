import type { Metadata } from "next";
import "./globals.css";
import "bootstrap/dist/css/bootstrap.min.css";



export const metadata: Metadata = {
  title: "My Next App",
  description: "Next app with laravel",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <body>
        <h1>My next js App!</h1>
      </body>
    </html>
  );
}
