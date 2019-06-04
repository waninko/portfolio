using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace EndlessRunner
{
    public partial class Form1 : Form
    {
        bool jumping = false;
        int jumpSpeed = 10;
        int force = 12;
        int score = 0;
        int obstacleSpeed = 10;
        Random rnd = new Random();


        public Form1()
        {
            InitializeComponent();

            resetGame();
        }

        private void gameEvent(object sender, EventArgs e)
        {
            //connecting jumpspeed with pictureboxes
            runner.Top += jumpSpeed;

            //show score in scoreText
            scoreText.Text = "Score: " + score;

            //if jumping is true and force less than 0, set jumping to false
            if (jumping && force < 0)
            {
                jumping = false;
            }

            //if jumping is true change jumpSpeed to -12, reduce force
            if (jumping)
            {
                jumpSpeed = -12;
                force -= 1;
            }
            else
            {
                //else set jumpSpeed to 12
                jumpSpeed = 12;
            }

            foreach (Control x in this.Controls)
            {
                //is X a pictureBox and an obstacle tag?
                if (x is PictureBox && x.Tag == "obstacle")
                {
                    x.Left -= obstacleSpeed; //move obst to the left

                    if (x.Left + x.Width < -120)
                    {
                        //if obstacles has moved offscreen - respawn at far right w/random numbers
                        x.Left = this.ClientSize.Width + rnd.Next(200, 800);
                        //add to score
                        score++;
                    }
                    //if collision with obstacle:
                    if (runner.Bounds.IntersectsWith(x.Bounds))
                    {   
                        //the timer stops
                        gameTimer.Stop();
                        //change runner img to "dead" one
                        runner.Image = Properties.Resources.dead;
                        //show restart info
                        scoreText.Text += "  Press R to restart  ";
                    }
                }
            }
            //if runner top is >= 380px and is not jumping
            if (runner.Top >= 300 && !jumping)
            {
                force = 12;
                runner.Top = floor.Top - runner.Height; //place player on top of pictureBox
                jumpSpeed = 0;
            }

            if (score >= 10)
            {
                //speed up obstacles as score increases
                obstacleSpeed = 15;
            }
        }

        private void keyisdown(object sender, KeyEventArgs e)
        {
            //if space is pressed and jumping bool is false, then jumping is true.
            if (e.KeyCode == Keys.Space && !jumping)
            {
                jumping = true;
            }
        }

        private void keyisup(object sender, KeyEventArgs e)
        {
            //if the R key is pressed & released - run the reset function
            if (e.KeyCode == Keys.R)
            {
                resetGame();
            }

            //when key is released - check if jumping, and set to false if true
            //so user can keep jumping
            if (jumping)
            {
                jumping = false;
            }
        }

        public void resetGame()
        {
            force = 12;
            runner.Top = floor.Top - runner.Height;
            jumpSpeed = 0;
            jumping = false;
            score = 0;
            obstacleSpeed = 10;
            scoreText.Text = "Score: " + score;
            runner.Image = Properties.Resources.running;

            foreach (Control x in this.Controls)
            {
                //is X a pictureBox and an obstacle?
                if (x is PictureBox && x.Tag == "obstacle")
                {
                    //get random nr in position
                    int position = rnd.Next(600, 1000);

                    //change obstacles left position to random
                    x.Left = 640 + (x.Left + position + x.Width * 3);
                }
            }
            gameTimer.Start(); 
        }
    }
}
